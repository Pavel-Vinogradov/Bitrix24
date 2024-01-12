<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "auth";');

        Schema::create('auth.access_tokens', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('access_token')->nullable(false)->comment('token value');//AUTH_ID
            $table->timestamp('expires_at')->nullable(false)->comment('token expiration date');
            $table->timestamp('created_at')->nullable(false)->comment('token creation date');
            $table->foreign('user_id')->references('id')->on('user.users')->onDelete('cascade');
            $table->comment(' Табличный ключ доступа');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth.access_tokens');
    }
};
