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
        Schema::table('comments', function (Blueprint $table) {
            // Drop the redundant 'content' column if it exists
            if (Schema::hasColumn('comments', 'content')) {
                $table->dropColumn('content');
            }

            // Ensure the 'body' column exists, as the application uses it
            if (!Schema::hasColumn('comments', 'body')) {
                $table->text('body')->after('movie_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // If we roll back, we might want to add the 'content' column back
            // for the sake of reversing the state perfectly.
            if (!Schema::hasColumn('comments', 'content')) {
                $table->text('content')->after('movie_id');
            }
        });
    }
};