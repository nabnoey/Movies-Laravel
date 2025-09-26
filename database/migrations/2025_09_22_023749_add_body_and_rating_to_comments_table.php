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
        $table->text('body')->after('movie_id');       // เนื้อหาคอมเมนต์
        $table->unsignedTinyInteger('rating')->after('body'); // คะแนน 1–5
    });
}

public function down(): void
{
    Schema::table('comments', function (Blueprint $table) {
        $table->dropColumn(['body', 'rating']);
    });
}
};