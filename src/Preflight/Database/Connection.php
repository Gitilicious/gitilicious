<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Database;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;

class Connection
{
    public function test(string $name, string $hostname, string $username, string $password): Results
    {
        $results = new Results();

        $results->addResult($this->connectToDatabase($name, $hostname, $username, $password));

        if (!$results->isPassed()) {
            return $results;
        }

        return $results;
    }

    private function connectToDatabase(string $name, string $hostname, string $username, string $password): Result
    {
        try {
            new \PDO(sprintf('pgsql:dbname=%s;host=%s;', $name, $hostname), $username, $password);
        } catch(\PDOException $e) {
            return new Fail($this->mapErrorCodesToTextId($e->getCode()), $e->getCode() . '::' . $e->getMessage());
        } catch (\Throwable $e) {
            return new Fail('preflight.database.connection.error.unknown', $e->getCode() . '::' . $e->getMessage());
        }

        return new Pass('preflight.database.connection.success');
    }

    private function mapErrorCodesToTextId(int $errorCode): string
    {
        switch ($errorCode) {
            case 7:
                return 'preflight.database.connection.error.noconnection';
            
            default:
                return 'preflight.database.connection.error.unknown';
        }
    }
}
