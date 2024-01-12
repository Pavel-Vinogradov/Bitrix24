<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tizix\Bitrix24Laravel\Enum\FileType;

return new class () extends Migration {
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS "file";');

        Schema::create('file.file_types', static function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable(true);
            $table->comment('Таблица Типов файлов');

        });
        foreach (FileType::cases() as $case) {
            DB::table('file.file_types')->insert([
                'id' => $case->value,
                'name' => $case->name,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('file.file_types');
    }
};
