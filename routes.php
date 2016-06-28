<?php declare(strict_types=1);

namespace Gitilicious;

use Gitilicious\Presentation\Controller\Resource;
use Gitilicious\Presentation\Controller\Error;
//use ProjectX\Presentation\Controller\User;
use Gitilicious\Presentation\Controller\Installation;
use Gitilicious\Presentation\Controller\Preflight;
use Gitilicious\Presentation\Controller\Index;

/** @var \CodeCollab\Router\Router $router */
$router
    ->get('/js/{filename:.+}', [Resource::class, 'renderJavascript'])
    ->get('/css/{filename:.+}', [Resource::class, 'renderStylesheet'])
    ->get('/fonts/{filename:.+}', [Resource::class, 'renderFont'])
    ->get('/not-found', [Error::class, 'notFound'])
    ->get('/method-not-allowed', [Error::class, 'methodNotAllowed'])
;

/** @var bool $config */
if (!$config['initialized']) {
    $router->get('/', [Installation::class, 'render']);
    $router->post('/', [Installation::class, 'handle']);
    $router->get('/preflight', [Preflight::class, 'preflight']);
    $router->get('/preflight/database-connection', [Preflight::class, 'databaseConnection']);
    $router->post('/preflight/database-connection/test', [Preflight::class, 'testDatabaseConnection']);
    $router->get('/preflight/empty-database', [Preflight::class, 'emptyDatabase']);
    $router->post('/preflight/empty-database/test', [Preflight::class, 'testEmptyDatabase']);
    $router->get('/preflight/create-table', [Preflight::class, 'createTable']);
    $router->post('/preflight/create-table/test', [Preflight::class, 'testCreateTable']);
    $router->get('/preflight/drop-table', [Preflight::class, 'dropTable']);
    $router->post('/preflight/drop-table/test', [Preflight::class, 'testDropTable']);
    $router->get('/preflight/repo-directory', [Preflight::class, 'repoDirectory']);
    $router->post('/preflight/repo-directory/test', [Preflight::class, 'testRepoDirectory']);
    $router->get('/preflight/sendmail', [Preflight::class, 'sendmail']);
    $router->post('/preflight/sendmail/test', [Preflight::class, 'testSendmail']);
    
    return;
}

$router->get('/', [Index::class, 'index']);

/** @var \CodeCollab\Authentication\User $user */
/*
if (!$user->isLoggedIn()) {
    $router
        ->get('/', [User::class, 'login'])
        ->post('/', [User::class, 'doLogin'])
        ->get('/cookie-login', [User::class, 'doCookieLogin'])
    ;
} else {
    $router
        ->get('/', [Index::class, 'index'])
        ->post('/logout', [User::class, 'doLogout'])
    ;
}
*/
