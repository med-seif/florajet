<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Source;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        # adding sources
        $source1 = new Source(name: 'src-1');
        $manager->persist($source1);
        $source2 = new Source(name: 'src-2');
        $manager->persist($source2);
        # adding articles
        $article1 = new Article(name: 'Article 1', content: 'Lorem ipsum dolor sit amet 1', source_id: $source1);
        $manager->persist($article1);
        $article2 = new Article(name: 'Article 2', content: 'Lorem ipsum dolor sit amet 2', source_id: $source2);
        $manager->persist($article2);
        $article3 = new Article(name: 'Article 3', content: 'Lorem ipsum dolor sit amet 3', source_id: $source2);
        $manager->persist($article3);
        $article4 = new Article(name: 'Article 4', content: 'Lorem ipsum dolor sit amet 4', source_id: $source1);
        $manager->persist($article4);
        $manager->flush();
    }
}
