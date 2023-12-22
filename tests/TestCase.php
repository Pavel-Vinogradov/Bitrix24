<?php

declare(strict_types=1);

namespace Tizix\Bitrix24Laravel\Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase as BaseUnitTest;
use Tizix\Bitrix24Laravel\Tests\Components\Faker\Generator;

abstract class TestCase extends BaseUnitTest
{
    use DatabaseMigrations;

    protected function faker(): Generator
    {
        return Factory::create();
    }
}
