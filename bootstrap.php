<?php declare(strict_types=1);

namespace Gitilicious;

use CodeCollab\Http\Request\Request;
use CodeCollab\Http\Cookie\Factory as CookieFactory;
use CodeCollab\Http\Session\Session;
use CodeCollab\Http\Session\Native as NativeSession;
use CodeCollab\Authentication\Authentication;
use CodeCollab\Authentication\User;
use CodeCollab\Encryption\Encryptor;
use CodeCollab\Encryption\Defuse\Encryptor as EncryptorImpl;
use CodeCollab\Encryption\Decryptor;
use CodeCollab\Encryption\Defuse\Decryptor as DecryptorImpl;
use CodeCollab\Router\Router;
use FastRoute\RouteParser;
use FastRoute\RouteParser\Std as StdRouteParser;
use FastRoute\DataGenerator;
use FastRoute\DataGenerator\GroupCountBased as GroupCountBasedDataGenerator;
use FastRoute\Dispatcher\GroupCountBased as RouteDispatcher;
use CodeCollab\Router\Injector;
use CodeCollab\Router\FrontController;
use Gitilicious\Presentation\Template\Html;
use CodeCollab\Theme\Loader as ThemeLoader;
use CodeCollab\Theme\Theme;
use CodeCollab\I18n\Translator;
use CodeCollab\I18n\FileTranslator;
use CodeCollab\CsrfToken\Generator\Generator as TokenGenerator;
use CodeCollab\CsrfToken\Generator\RandomBytes32;
use CodeCollab\CsrfToken\Storage\Storage as TokenStorage;
use Gitilicious\Storage\TokenSession;
use CodeCollab\CsrfToken\Token;
use CodeCollab\CsrfToken\Handler as CsrfToken;
use Gitilicious\Form\Install as InstallForm;
use Auryn\Injector as Auryn;

/**
 * Setup the project autoloader
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Setup the environment
 */
require_once __DIR__ . '/init.deployment.php';

/**
 * Load the configuration
 */
require_once __DIR__ . '/config/config.php';

/**
 * Prevent further execution when on CLI
 */
if (php_sapi_name() === 'cli') {
    return;
}

/**
 * Setup DI
 */
$auryn    = new Auryn();
$injector = new Injector($auryn);
$auryn->share($auryn); // yolo

/**
 * Setup encryption
 */
$auryn->share(Decryptor::class);
$auryn->alias(Decryptor::class, DecryptorImpl::class);
$auryn->alias(Encryptor::class, EncryptorImpl::class);
$auryn->define(DecryptorImpl::class, [':key' => file_get_contents(__DIR__ . '/encryption.key')]);
$auryn->define(EncryptorImpl::class, [':key' => file_get_contents(__DIR__ . '/encryption.key')]);

/**
 * Setup the request object
 */
$auryn->share(Request::class);
$request = $auryn->make(Request::class, [
    ':server'  => $_SERVER,
    ':get'     => $_GET,
    ':post'    => $_POST,
    ':files'   => $_FILES,
    ':cookies' => $_COOKIE,
    ':input'   => file_get_contents('php://input'),
]);

/**
 * Setup cookies
 */
$auryn->define(CookieFactory::class, [
    ':domain' => $request->server('SERVER_NAME'),
    ':secure' => $request->isEncrypted(),
]);

/**
 * Setup the session
 */
$auryn->share(Session::class);
$auryn->alias(Session::class, NativeSession::class);
$auryn->define(NativeSession::class, [
    ':path'   => '/',
    ':domain' => $request->server('SERVER_NAME'),
    ':secure' => $request->isEncrypted()
]);

/**
 * Setup the user authentication
 */
$auryn->share(User::class);
$auryn->alias(Authentication::class, User::class);
$user = $auryn->make(User::class);

/**
 * Setup the router
 */
$cacheFile = $user->isLoggedIn() ? __DIR__ . '/cache/routes-authenticated.php' : __DIR__ . '/cache/routes.php';
/** @var array $config */
$cacheFile = $config['initialized'] ? $cacheFile : __DIR__ . '/cache/routes-installation.php';
$auryn->share(Router::class);
$auryn->alias(RouteParser::class, StdRouteParser::class);
$auryn->alias(DataGenerator::class, GroupCountBasedDataGenerator::class);
/** @var bool $production */
$auryn->define(Router::class, [
    ':dispatcherFactory' => function($dispatchData) {
        return new RouteDispatcher($dispatchData);
    },
    ':cacheFile' => $cacheFile,
    ':forceReload' => !$production,
]);
$router = $auryn->make(Router::class);

/**
 * Setup the templating
 */
$auryn->define(Html::class, [':basePage' => '/page.phtml']);
$auryn->alias(ThemeLoader::class, Theme::class);
/** @var array $config */
$auryn->define(Theme::class, [':themePath' => __DIR__ . '/themes', ':theme' => $config['theme']]);

/**
 * Setup translator
 */
$auryn->share(Translator::class);
$auryn->alias(Translator::class, FileTranslator::class);
$auryn->define(FileTranslator::class, [':translationDirectory' => __DIR__ . '/texts', ':languageCode' => 'en_US']);

/**
 * Setup the CSRF token
 */
$auryn->alias(Token::class, CsrfToken::class);
$auryn->alias(TokenStorage::class, TokenSession::class);
$auryn->alias(TokenGenerator::class, RandomBytes32::class);

/**
 * Setup custom form data
 */
$auryn->define(InstallForm::class, [':baseDirectory' => __DIR__]);

/**
 * Load the routes
 */
require_once __DIR__ . '/routes.php';

/**
 * Setup the front controller
 */
$frontController = $auryn->make(FrontController::class);

/**
 * Run the application
 */
$frontController->run($request);
