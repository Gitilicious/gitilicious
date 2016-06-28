<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use Gitilicious\Presentation\Template\Html;

class Index
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index(Html $template): Response
    {
        $this->response->setContent($template->renderPage('/index.phtml'));
        
        return $this->response;
    }
}
