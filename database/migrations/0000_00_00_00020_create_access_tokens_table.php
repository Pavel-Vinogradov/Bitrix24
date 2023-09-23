<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "auth";');

        Schema::create('auth.access_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('value')->nullable(false)->comment('token value');
            $table->timestamp('expires_at')->nullable(false)->comment('token expiration date');
            $table->timestamp('created_at')->nullable(false)->comment('token creation date');
            $table->foreign('user_id')->references('id')->on('user.users')->onDelete('cascade');
            $table->comment(' Табличный ключ доступа');
        });
    }

    public function down(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS "auth" CASCADE;');
        Schema::dropIfExists('auth.access_tokens');
    }
};
