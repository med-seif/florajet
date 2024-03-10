<?php

namespace App\Data;

/**
 * A basic definition for classes implementing iterator
 */
trait IteratorTrait
{
    private int $currentPosition = 0;
    /**
     * @inheritDoc
     */
    #[\Override]
    public function current(): object
    {
        return $this->data[$this->currentPosition];
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function next(): void
    {
        ++$this->currentPosition;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function key(): int
    {
        return $this->currentPosition;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function valid(): bool
    {
        return isset($this->data[$this->currentPosition]);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function rewind(): void
    {
        $this->currentPosition = 0;
    }
}
