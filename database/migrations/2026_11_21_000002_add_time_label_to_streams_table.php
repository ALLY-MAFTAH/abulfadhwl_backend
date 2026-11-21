<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Time shown in the timetable (e.g. "Baada ya Magharibi"); `description` stays the lesson's subtitle. */
    public function up()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->string('time_label')->nullable();
        });
    }

    public function down()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->dropColumn('time_label');
        });
    }
};
