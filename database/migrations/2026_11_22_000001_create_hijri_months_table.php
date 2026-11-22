<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The first day of each Hijri month, entered by the admin once the new moon
 * has been SEEN (not calculated). The app builds its calendar from these and
 * only estimates the months that have not been confirmed yet.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('hijri_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('hijri_year');
            $table->unsignedTinyInteger('hijri_month'); // 1 = Muharram ... 12 = Dhul Hijjah
            $table->date('starts_on');                   // Gregorian date of day 1
            $table->string('note', 160)->nullable();
            $table->timestamps();
            $table->unique(['hijri_year', 'hijri_month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hijri_months');
    }
};
