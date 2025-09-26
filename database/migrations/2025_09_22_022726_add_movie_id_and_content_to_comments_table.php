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
              // เพิ่มคอลัมน์ movie_id
            $table->unsignedBigInteger('movie_id')->after('id');

            // เพิ่มคอลัมน์ content สำหรับข้อความ comment
            $table->text('content')->after('movie_id');

            // กำหนด foreign key ไปยังตาราง movies
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
             // ลบ foreign key ก่อน
            $table->dropForeign(['movie_id']);

            // ลบคอลัมน์ที่เพิ่มมา
            $table->dropColumn(['movie_id', 'content']);
            //
        });
    }
};
