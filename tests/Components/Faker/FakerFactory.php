<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests\Components\Faker;

use Faker\Factory;

final class FakerFactory extends Factory
{
    public static function create($locale = self::DEFAULT_LOCALE): Generator
    {
        return self::createFromClass($locale);
    }

    private static function createFromClass($locale): Generator
    {
        $generator = new Generator();

        foreach (FakerFactory::$defaultProviders as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;
    }
}
