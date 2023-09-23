<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('file.model_files', function (Blueprint $table) {
            $table->id();
            $table->integer('file_id')->nullable(false);
            $table->string('model_class')->nullable(false);
            $table->string('model_id')->nullable(false);
            $table->timestamps();
            $table->foreign('file_id')->references('id')->on('file.files')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file.model_files');
    }
};
