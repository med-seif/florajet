<?php

namespace App\Data\Collector\Article;

use App\Exceptions\DatabaseCollectorException;
use App\Factory\DbConnectionFactory;
use Doctrine\DBAL\Exception;
use Faker\Generator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatabaseCollector extends AbstractArticleCollector
{
    private OptionsResolver $resolver;

    public function __construct(private readonly DbConnectionFactory $dbConnectionFactory,
                                private readonly Generator           $faker)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->resolver = $resolver;
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'dbname',
            'user',
            'password',
            'host',
        ]);
    }

    /**
     * @throws Exception
     * @throws DatabaseCollectorException
     */
    #[\Override]
    public function collectData(array $params = []): array
    {
        $params = $this->resolver->resolve($params);
        $params ['driver'] = 'pdo_mysql';

        $db = $this->dbConnectionFactory->createConnection($params);
        # ...
        # making SQL query
        # parse data to match array of keys 'name','content','source_name'
        # ...

        # Data generation , we'll use a faker to simulate data generation and a heavy task
        $i = 0;
        $data = [];
        while ($i <= 100) {
            $data[] = [
                'name' => $this->faker->text('20'),
                'content' => $this->faker->text(),
                'source_name' => $this->faker->randomElement([
                    'Le Monde', 'Le Figaro', 'NY Times',
                    'Libération', 'L\'équipe', 'La Tribune'
                ])
            ];
            $i++;
        }
        return $data;
    }

    #[\Override]
    public static function getIndex(): string
    {
        return CollectorTypeEnum::Database->value;
    }
}
