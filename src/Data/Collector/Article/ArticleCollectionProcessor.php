<?php

namespace App\Data\Collector\Article;

use App\Entity\Article;
use App\Entity\Source;
use App\Repository\ArticleRepository;
use App\Repository\SourceRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class ArticleCollectionProcessor
{
    public function __construct(private EntityManagerInterface $em,
                                private SourceRepository       $sourceRepository,
                                private ArticleRepository      $articleRepository)
    {
    }

    public function save(array $articles): int
    {
        foreach ($articles as $a) {
            $sourceName = $a['source_name'];
            $article = (new Article())
                ->setName($a['name'])
                ->setContent($a['content'])
                ->setSourceId(
                    $this->getSource($sourceName)
                );
            $this->em->persist($article);
            $this->em->flush();
        }
        return 0;
    }

    /**
     * If source name already exists return existing record otherwise create it before returning it
     *
     * @param string|null $sourceName
     * @return Source|null
     */
    private function getSource(string|null $sourceName): Source|null
    {
        if (!$sourceName) {
            return null;
        }
        $row = $this->sourceRepository->findOneBy(['name' => $sourceName]);
        # already exists in db
        if ($row) {
            return $row;
        }
        # insert new source before article
        $source = (new Source())
            ->setName($sourceName);
        $this->em->persist($source);
        $this->em->flush();

        return $source;
    }
}
