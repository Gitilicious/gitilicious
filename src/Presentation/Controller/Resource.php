<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use Gitilicious\Presentation\Template\Html;

class Resource
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function renderStylesheet(Html $template, string $filename): Response
    {
        $this->response->setContent($template->render('/resources/css/' . $filename));
        $this->response->addHeader('Content-Type', 'text/css');
        
        return $this->response;
    }

    public function renderJavascript(Html $template, string $filename): Response
    {
        $this->response->setContent($template->render('/resources/js/' . $filename));
        $this->response->addHeader('Content-Type', 'application/javascript');

        return $this->response;
    }

    public function renderFont(Html $template, string $filename): Response
    {
        $this->response->setContent($template->render('/resources/fonts/' . $filename));
        $this->response->addHeader('Content-Type', $this->setFontContentType($filename));

        return $this->response;
    }

    private function setFontContentType(string $filename): string
    {
        switch (pathinfo($filename)['extension']) {
            case 'otf':
                return 'application/x-font-otf';

            case 'eot':
                return 'application/vnd.ms-fontobject';

            case 'svg':
                return 'image/svg+xml';

            case 'ttf':
                return 'application/x-font-ttf';

            case 'woff':
                return 'application/font-woff';

            case 'woff2':
                return 'application/font-woff2';

            default:
                return 'application/octet-stream';
        }
    }
}
