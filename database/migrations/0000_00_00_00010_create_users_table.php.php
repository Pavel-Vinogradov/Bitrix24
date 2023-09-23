<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "user";');

        Schema::create('user.users', function (Blueprint $table) {
            $table->unsignedInteger('id')->unique()->nullable(false);
            $table->string('name')->nullable(false)->comment('ФИО')->fulltext('idx_user_name');
            $table->string('email')->default('')->comment('E-mail');
            $table->string('phone')->default('')->comment('Телефон');
            $table->string('work_position')->default('')->comment('Должность');
            $table->boolean('is_active')->default(true)->comment('Удален ли пользователь');
            $table->timestamps();
            $table->comment('Таблица пользователей');
        });
    }

    public function down(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS "user" CASCADE;');
        Schema::dropIfExists('user.users');
    }
};
