<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use CodeCollab\Http\Response\StatusCode;
use CodeCollab\Http\Request\Request;
use Gitilicious\Presentation\Template\Html;
use Gitilicious\Form\Install as InstallationForm;
use Gitilicious\Storage\Sql\Database as DatabaseStorage;
use Gitilicious\Storage\Sql\User as UserStorage;

class Installation
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function render(Html $template, InstallationForm $form): Response
    {
        $this->response->setContent($template->renderPage('/installation/index.phtml', [
            'hideNavigation' => true,
            'form'           => $form,
            'extraJs'        => ['/js/gitilicious/preflight.js'],
        ]));
        
        return $this->response;
    }

    public function handle(
        Request $request,
        Html $template,
        InstallationForm $form,
        DatabaseStorage $databaseStorage,
        UserStorage $userStorage
    ): Response
    {
        $form->bindRequest($request);

        if (!$form->isValid()) {
            return $this->render($template, $form);
        }

        $databaseStorage->createTables($form);
        $userStorage->createFromInstallation($form);

        $this->response->addHeader('Location', $request->getBaseUrl());
        $this->response->setStatusCode(StatusCode::FOUND);

        return $this->response;
    }
}
