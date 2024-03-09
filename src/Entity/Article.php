<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private ?string $content;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Source $source_id = null;

    /**
     * Give the possibility to define parameters while instantiation
     *
     * @param string|null $name
     * @param string|null $content
     * @param Source|null $source_id
     */
    public function __construct(?string $name = null, ?string $content = null, ?Source $source_id = null)
    {
        $this->name = $name ?: null;
        $this->content = $content ?: null;
        $this->source_id = $source_id ?: null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSourceId(): ?Source
    {
        return $this->source_id;
    }

    public function setSourceId(?Source $source_id): static
    {
        $this->source_id = $source_id;

        return $this;
    }
}
