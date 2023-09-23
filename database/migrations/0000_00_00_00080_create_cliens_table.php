<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "client";');

        Schema::create('client.clients', function (Blueprint $table) {
            $table->unsignedInteger('id')->nullable(false)->unique()->primary();
            $table->string('name')->nullable(false)->fulltext('idx_client_name');
            $table->string('tax_payer_id')->nullable(true);
            $table->string('tax_registration_reason_code')->nullable(true);
        });

    }

    public function down(): void
    {
        DB::statement('DROP SCHEMA IF EXISTS "client" CASCADE;');
        Schema::dropIfExists('client.clients');
    }
};
