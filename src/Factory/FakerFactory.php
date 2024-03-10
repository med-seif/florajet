<?php

namespace App\Factory;

use Faker\Factory;
use Faker\Generator;
/**
 * Singleton Class with private constructor
 */
class FakerFactory
{
    private static Generator|null $instance = null;


    private function __construct()
    {
    }

    public static function create(): Generator
    {
        if (null === self::$instance) {
            return self::$instance = Factory::create('fr');
        }
        return self::$instance;
    }
}
