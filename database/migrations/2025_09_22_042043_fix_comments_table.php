<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'body')) {
                $table->text('body')->after('movie_id');
            }

            if (!Schema::hasColumn('comments', 'rating')) {
                $table->unsignedTinyInteger('rating')->default(0)->after('body');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'body')) {
                $table->dropColumn('body');
            }

            if (Schema::hasColumn('comments', 'rating')) {
                $table->dropColumn('rating');
            }
        });
    }
};
