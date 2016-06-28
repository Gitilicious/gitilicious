<?php declare(strict_types=1);

namespace Gitilicious;

use CodeCollab\Encryption\Defuse\Key;

require_once __DIR__ . '/../bootstrap.php';

$encryptionKey = new Key();

file_put_contents(__DIR__ . '/../encryption.key', $encryptionKey->generate());
