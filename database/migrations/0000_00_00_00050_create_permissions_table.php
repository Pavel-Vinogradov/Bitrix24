<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('rbac.permissions', static function (Blueprint $table): void {
            $table->id();
            $table->string('key')->nullable(false)->unique()->comment('ключ');
            $table->string('name')->nullable(false)->unique()->comment('название');
            $table->comment('Таблица Прав');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac.permissions');
    }
};
