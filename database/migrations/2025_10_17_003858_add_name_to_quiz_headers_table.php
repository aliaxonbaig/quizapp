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
            $table->string('name')->nullable()->after('user_id');
            $table->boolean('is_school_test')->default(false)->after('learningmode');
            $table->dateTime('test_date')->nullable()->after('is_school_test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropColumn(['name', 'is_school_test', 'test_date']);
        });
    }
};
