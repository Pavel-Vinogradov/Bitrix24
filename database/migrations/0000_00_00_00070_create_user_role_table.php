<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('rbac.user_role', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('user_id')->references('id')->on('user.users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('rbac.roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac.user_role');
    }
};
