<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Order of a song inside its album, and whether the app should show it. */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            if (! Schema::hasColumn('songs', 'position')) {
                $table->unsignedInteger('position')->default(0);
            }
            if (! Schema::hasColumn('songs', 'active')) {
                $table->boolean('active')->default(true);
            }
        });
    }

    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn(['position', 'active']);
        });
    }
};
