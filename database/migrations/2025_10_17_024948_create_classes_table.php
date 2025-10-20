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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "CISSP Exam - October 17, 2025"
            $table->text('description')->nullable();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->date('test_date'); // The date when the test was administered
            $table->time('test_time')->nullable(); // Optional time
            $table->foreignId('certification_id')->nullable()->constrained('certifications');
            $table->json('domains')->nullable(); // Which domains were covered
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot table to link quiz_headers to classes
        Schema::create('class_quiz_header', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('quiz_header_id')->constrained('quiz_headers')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['class_id', 'quiz_header_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_quiz_header');
        Schema::dropIfExists('classes');
    }
};
