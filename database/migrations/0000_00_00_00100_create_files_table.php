<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {

        Schema::create('file.files', static function (Blueprint $table): void {
            $table->id();
            $table->string('external_id')->nullable(true);
            $table->integer('type_id')->nullable(false);
            $table->string('hash')->nullable(false);
            $table->string('link')->nullable(false);
            $table->integer('size')->nullable(false);
            $table->string('name')->nullable(false);
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('file.file_types')->onDelete('cascade');
            $table->comment('Таблица загруженных файлов');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file.files');
    }
};
