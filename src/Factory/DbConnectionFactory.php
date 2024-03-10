<?php

namespace App\Factory;

use App\Exceptions\DatabaseCollectorException;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DbConnectionFactory
{
    private OptionsResolver $resolver;

    public function __construct(
        private readonly Configuration $dbalConfiguration)
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
            'driver'
        ]);
    }

    /**
     * @throws Exception
     * @throws DatabaseCollectorException
     */
    public function createConnection(array $params)
    {
        $params = $this->resolver->resolve($params);
        $connection = DriverManager::getConnection($params, $this->dbalConfiguration);
        /*
        if (!$connection->isConnected()) { # disabled for testing
            throw new DatabaseCollectorException('External database connection impossible');
        }
        */
        return $connection;
    }
}
