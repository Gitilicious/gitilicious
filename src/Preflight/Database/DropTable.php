<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Database;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;

class DropTable
{
    public function test(string $name, string $hostname, string $username, string $password): Results
    {
        $results = new Results();

        $results->addResult($this->verifyDropTablePermissions($name, $hostname, $username, $password));

        return $results;
    }

    private function verifyDropTablePermissions(string $name, string $hostname, string $username, string $password): Result
    {
        $dbConnection = new \PDO(sprintf('pgsql:dbname=%s;host=%s;', $name, $hostname), $username, $password);

        try {
            $stmt = $dbConnection->query('DROP TABLE test');

            return new Pass('preflight.database.droptable.success');
        } catch (\PDOException $e) {
            return new Fail('preflight.database.droptable.nopermissions', $e->getMessage());
        }
    }
}
