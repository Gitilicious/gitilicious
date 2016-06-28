<?php declare(strict_types=1);

namespace Gitilicious\Preflight;

class Fail extends Result
{
    public function __construct(string $message, string $extraData = null)
    {
        parent::__construct(false, $message, $extraData);
    }

    public function getType(): string
    {
        return 'fail';
    }
}
