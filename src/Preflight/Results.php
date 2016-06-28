<?php declare(strict_types=1);

namespace Gitilicious\Preflight;

class Results implements \Iterator
{
    private $position = 0;

    private $results = [];

    public function addResult(Result $result)
    {
        $this->results[] = $result;
    }

    public function isPassed(): bool
    {
        foreach ($this->results as $result) {
            if (!$result->isPassed()) {
                return false;
            }
        }

        return true;
    }

    public function current()
    {
        return $this->results[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return array_key_exists($this->position, $this->results);
    }

    public function rewind()
    {
        $this->position = 0;
    }
}
