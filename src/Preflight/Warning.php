<?php declare(strict_types=1);

namespace Gitilicious\Preflight;

class Warning extends Result
{
    public function __construct(string $message, string $extraData = null)
    {
        parent::__construct(true, $message, $extraData);
    }
    
    public function getType(): string
    {
        return 'warn';
    }
}
