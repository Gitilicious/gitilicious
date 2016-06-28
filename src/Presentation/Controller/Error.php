<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use CodeCollab\Http\Response\StatusCode;
use Gitilicious\Presentation\Template\Html;

class Error
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function notFound(Html $template)
    {
        $this->response->setContent($template->renderPage('/error/not-found.phtml'));
        $this->response->setStatusCode(StatusCode::NOT_FOUND);

        return $this->response;
    }

    public function methodNotAllowed(Html $template)
    {
        $this->response->setContent($template->renderPage('/error/not-found.phtml'));
        $this->response->setStatusCode(StatusCode::METHOD_NOT_ALLOWED);
        
        return $this->response;
    }
}
