<?php

namespace Tizix\Bitrix24Laravel;

use Illuminate\Support\ServiceProvider;

class BitrixServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/bitrix.php' => config_path('bitrix.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
