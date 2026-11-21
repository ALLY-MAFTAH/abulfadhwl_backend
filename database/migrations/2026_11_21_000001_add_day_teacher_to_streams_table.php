<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Structured weekly timetable: each lesson knows its weekday and teacher. */
    public function up()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->string('day', 3)->nullable();            // mon tue wed thu fri sat sun
            $table->string('teacher')->nullable();
            $table->unsignedInteger('position')->default(0);  // order within a day
        });
    }

    public function down()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->dropColumn(['day', 'teacher', 'position']);
        });
    }
};
