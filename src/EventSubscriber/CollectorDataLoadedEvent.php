<?php

namespace App\EventSubscriber;

use Symfony\Contracts\EventDispatcher\Event;

class CollectorDataLoadedEvent extends Event
{
    private array $articles;

    public function setArticles(array $articles): static
    {
        $this->articles = $articles;
        return $this;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }
}
