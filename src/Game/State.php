<?php

namespace Plastonick\WordleEngine\Game;

use function array_merge;

final class State
{
    /**
     * @param Result[] $results
     * @param bool $isComplete
     * @param bool $isSuccessful
     */
    public function __construct(
        public readonly array $results = [],
        public readonly bool $isComplete = false,
        public readonly bool $isSuccessful = false
    ) {
    }

    public function withResult(Result $result): self
    {
        return new self(array_merge($this->results, [$result]));
    }

    public function asComplete(): self
    {
        return new self($this->results, true, $this->isSuccessful);
    }

    public function asSuccessful(): self
    {
        return new self($this->results, $this->isComplete, true);
    }
}
