<?php

namespace App\Messenger;

readonly class LoadArticlesMessage
{
    public function __construct(
        private readonly array $content,
    )
    {
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
