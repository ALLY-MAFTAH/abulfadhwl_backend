<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Book name shown in the weekly timetable; the live title stays in `title`. */
    public function up()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->string('book')->nullable();
        });
    }

    public function down()
    {
        Schema::table('streams', function (Blueprint $table) {
            $table->dropColumn('book');
        });
    }
};
