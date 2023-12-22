<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('rbac.role_permission', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('role_id')->nullable(false);
            $table->unsignedInteger('permission_id')->nullable(false);
            $table->foreign('role_id')->references('id')->on('rbac.roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('rbac.permissions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac.role_permission');
    }
};
