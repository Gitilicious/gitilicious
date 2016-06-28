<?php declare(strict_types=1);

namespace Gitilicious\Presentation\Controller;

use CodeCollab\Http\Response\Response;
use CodeCollab\Http\Request\Request;
use Gitilicious\Preflight\Repository\Permission;
use Gitilicious\Presentation\Template\Html;
use Gitilicious\Preflight\Database\Connection;
use Gitilicious\Preflight\Database\EmptyCheck;
use Gitilicious\Preflight\Database\CreateTable;
use Gitilicious\Preflight\Database\DropTable;
use Gitilicious\Preflight\Mail\Sendmail;

class Preflight
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function preflight(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight.phtml'));

        return $this->response;
    }

    public function databaseConnection(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.connection.test',
        ]));

        return $this->response;
    }

    public function testDatabaseConnection(Html $template, Request $request, Connection $preflight): Response
    {
        $results = $preflight->test(
            $request->post('name'),
            $request->post('hostname'),
            $request->post('username'),
            $request->post('password')
        );

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }

    public function emptyDatabase(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.empty.test',
        ]));

        return $this->response;
    }

    public function testEmptyDatabase(Html $template, Request $request, EmptyCheck $preflight): Response
    {
        $results = $preflight->test(
            $request->post('name'),
            $request->post('hostname'),
            $request->post('username'),
            $request->post('password')
        );

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }

    public function createTable(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.createtable.test',
        ]));

        return $this->response;
    }

    public function testCreateTable(Html $template, Request $request, CreateTable $preflight): Response
    {
        $results = $preflight->test(
            $request->post('name'),
            $request->post('hostname'),
            $request->post('username'),
            $request->post('password')
        );

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }

    public function dropTable(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.droptable.test',
        ]));

        return $this->response;
    }

    public function testDropTable(Html $template, Request $request, DropTable $preflight): Response
    {
        $results = $preflight->test(
            $request->post('name'),
            $request->post('hostname'),
            $request->post('username'),
            $request->post('password')
        );

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }

    public function repoDirectory(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.repodir.test',
        ]));

        return $this->response;
    }

    public function testRepoDirectory(Html $template, Request $request, Permission $preflight): Response
    {
        $results = $preflight->test($request->post('directory'));

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }

    public function sendmail(Html $template): Response
    {
        $this->response->setContent($template->render('/installation/preflight-test.phtml', [
            'title' => 'preflight.database.sendmail.test',
        ]));

        return $this->response;
    }

    public function testSendmail(Html $template, Request $request, Sendmail $preflight): Response
    {
        $results = $preflight->test($request->post('address'), $request->post('name'));

        $this->response->setContent(json_encode([
            'criticalError' => !$results->isPassed(),
            'result'        => $template->render('/installation/preflight-feedback.phtml', ['results' => $results]),
        ]));

        $this->response->addHeader('Content-Type', 'application/json');

        return $this->response;
    }
}
