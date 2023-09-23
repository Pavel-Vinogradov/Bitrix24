<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('rbac.permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable(false)->unique()->comment('ключ');
            $table->string('name')->nullable(false)->unique()->comment('название');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rbac.permission');
    }
};
