<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "rbac";');

        Schema::create('rbac.roles', static function (Blueprint $table): void {
            $table->id();
            $table->string('key')->nullable(false)->unique()->comment('ключ роли');
            $table->string('name')->nullable(false)->unique()->comment('название роли');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac.roles');
    }
};
