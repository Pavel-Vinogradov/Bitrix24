<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "user";');

        Schema::create('user.users', static function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable(false)->comment('ФИО');
            $table->string('email')->default('')->comment('E-mail');
            $table->string('phone')->default('')->comment('Телефон');
            $table->string('work_position')->default('')->comment('Должность');
            $table->boolean('is_active')->default(true)->comment('Удален ли пользователь');
            $table->string('login')->comment('login')->nullable();
            $table->string('password')->comment('Пароль')->nullable();
            $table->unsignedInteger('bitrix_id')->nullable()->comment('ID пользователя из Bitrix24');
            $table->boolean('is_bitrix24_user')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->comment('Таблица пользователей');
            $table->fulltext('name')->language('russian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user.users');
    }
};
