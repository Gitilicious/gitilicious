<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Database;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;

class EmptyCheck
{
    public function test(string $name, string $hostname, string $username, string $password): Results
    {
        $results = new Results();

        $results->addResult($this->verifyDatabaseIsEmpty($name, $hostname, $username, $password));

        if (!$results->isPassed()) {
            return $results;
        }

        return $results;
    }

    private function verifyDatabaseIsEmpty(string $name, string $hostname, string $username, string $password): Result
    {
        $dbConnection = new \PDO(sprintf('pgsql:dbname=%s;host=%s;', $name, $hostname), $username, $password);

        $stmt = $dbConnection->query('select COUNT(*) FROM pg_stat_user_tables');

        if ($stmt->fetchColumn(0) === 0) {
            return new Pass('preflight.database.empty.success');
        } else {
            return new Fail('preflight.database.error.notempty');
        }
    }
}
