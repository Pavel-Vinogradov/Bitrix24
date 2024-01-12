<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('auth.refresh_tokens', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id')->nullable(false)->index('refresh_token_user_id_index');
            $table->unsignedBigInteger('access_token_id')->nullable(false)->index('refresh_token_access_token_id_index');
            $table->string('refresh_token')->nullable(false)->comment('REFRESH_ID');
            $table->timestamp('expires_at')->nullable(false);
            $table->timestamp('created_at')->nullable(false);
            $table->foreign('user_id')->references('id')->on('user.users')->onDelete('cascade');
            $table->foreign('access_token_id')->references('id')->on('auth.access_tokens')->onDelete('cascade');
            $table->comment('Табличный ключ для авторизации');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth.refresh_tokens');
    }
};
