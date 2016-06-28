<?php declare(strict_types=1);

namespace Gitilicious\Preflight\Repository;

use Gitilicious\Preflight\Results;
use Gitilicious\Preflight\Result;
use Gitilicious\Preflight\Pass;
use Gitilicious\Preflight\Fail;
use Gitilicious\Preflight\Warning;

class Permission
{
    public function test(string $directory): Results
    {
        $results = new Results();

        $results->addResult($this->verifyDirectoryExistsOrCanBeCreated($directory));

        if (!$results->isPassed()) {
            return $results;
        }

        $results->addResult($this->verifyEmptyDirectory($directory));

        $results->addResult($this->verifyWritePermissions($directory));

        if (!$results->isPassed()) {
            return $results;
        }

        $results->addResult($this->verifyExecutePermissions($directory));

        return $results;
    }

    private function verifyDirectoryExistsOrCanBeCreated(string $directory): Result
    {
        if (is_dir($directory)) {
            return new Pass('preflight.database.repodir.success.directoryexists');
        }

        @mkdir($directory);

        clearstatcache(true);

        if (!is_dir($directory)) {
            return new Fail('preflight.database.repodir.cannotcreatedirectory', error_get_last()['message']);
        }

        return new Pass('preflight.database.repodir.success.directorycreated');
    }

    private function verifyEmptyDirectory(string $directory): Result
    {
        if (count(glob($directory . '/*')) === 0) {
            return new Warning('preflight.database.repodir.directorynotempty');
        }
    }

    private function verifyWritePermissions(string $directory): Result
    {
        @mkdir($directory . '/test.git');

        clearstatcache(true);

        if (!is_dir($directory)) {
            return new Fail('preflight.database.repodir.nowritepermissions', error_get_last()['message']);
        }

        return new Pass('preflight.database.repodir.success.directorywritable');
    }

    private function verifyExecutePermissions(string $directory): Result
    {
        @rmdir($directory . '/test.git');

        clearstatcache(true);

        if (is_dir($directory . '/test.git')) {
            return new Fail('preflight.database.repodir.noremovepermissions', error_get_last()['message']);
        }

        return new Pass('preflight.database.repodir.success.directorydeleted');
    }
}
