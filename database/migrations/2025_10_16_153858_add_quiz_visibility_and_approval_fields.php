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
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->boolean('is_private')->default(false)->after('user_id');
            $table->boolean('is_student_created')->default(false)->after('is_private');
            $table->boolean('is_approved')->default(false)->after('is_student_created');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['is_private', 'is_student_created', 'is_approved', 'approved_at', 'approved_by']);
        });
    }
};
