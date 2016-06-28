<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Mail;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;

class Sendmail
{
    public function test(string $address, string $name): Results
    {
        $results = new Results();

        $results->addResult($this->verifySendingMail($address, $name));

        return $results;
    }

    private function verifySendingMail(string $address, string $name): Result
    {
        $transport = \Swift_SendmailTransport::newInstance();
        $mailer    = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance('ProjectX Test mail')
            ->setFrom(['root@gitilicious.com' => 'Gitilicious'])
            ->setTo([$address => $name])
            ->setBody('Test message from the Gitilicious application.')
        ;

        try {
            if (!$mailer->send($message)) {
                return new Fail('preflight.database.sendmail.cannot_send_message');
            }
        } catch (\Swift_TransportException $e) {
            return new Fail('preflight.database.sendmail.cannot_send_message', $e->getMessage());
        }


        return new Pass('preflight.database.sendmail.success');
    }
}
