<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "util";');

        Schema::create('util.logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('model_class')->nullable();
            $table->integer('model_id')->nullable();
            $table->text('previous_value');
            $table->text('new_value');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('user.users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('util.logs');
    }
};
