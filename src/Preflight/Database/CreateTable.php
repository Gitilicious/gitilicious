<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Database;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;

class CreateTable
{
    public function test(string $name, string $hostname, string $username, string $password): Results
    {
        $results = new Results();

        $results->addResult($this->verifyCreateTablePermissions($name, $hostname, $username, $password));

        if (!$results->isPassed()) {
            return $results;
        }

        return $results;
    }

    private function verifyCreateTablePermissions(string $name, string $hostname, string $username, string $password): Result
    {
        $dbConnection = new \PDO(sprintf('pgsql:dbname=%s;host=%s;', $name, $hostname), $username, $password);

        try {
            $stmt = $dbConnection->query('CREATE TABLE test (id integer NOT NULL)');

            return new Pass('preflight.database.createtable.success');
        } catch (\PDOException $e) {
            return new Fail('preflight.database.createtable.nopermissions', $e->getMessage());
        }
    }
}
