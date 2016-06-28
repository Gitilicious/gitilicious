<?php declare(strict_types=1);

namespace Gitilicious\Preflight;

abstract class Result
{
    protected $passed;

    protected $message;

    protected $extraData;

    public function __construct(bool $passed, string $message, string $extraData = null)
    {
        $this->passed    = $passed;
        $this->message   = $message;
        $this->extraData = $extraData;
    }

    public function isPassed(): bool
    {
        return $this->passed;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getExtraData(): string
    {
        return $this->extraData ?: '';
    }

    abstract public function getType(): string;
}
