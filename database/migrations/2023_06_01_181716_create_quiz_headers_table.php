<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('certification_id')->constrained()->onDelete('cascade');
            $table->text('domains')->nullable()->default(null);
            $table->text('difficulty')->nullable()->default(null);
            $table->boolean('learningmode')->default(false);
            $table->boolean('completed')->default(false);
            $table->Integer('quiz_size');
            $table->text('questions_taken')->nullable()->default(null);
            $table->double('score', 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_headers');
    }
};
