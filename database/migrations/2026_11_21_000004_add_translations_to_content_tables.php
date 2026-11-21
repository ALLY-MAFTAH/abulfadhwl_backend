<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['streams', 'announcements', 'push_notifications'];

    /**
     * Extra languages for admin-written content, stored as
     * {"en": {"title": "...", ...}, "ar": {...}}. Kiswahili stays in the
     * original columns, so nothing existing changes.
     */
    public function up()
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->text('translations')->nullable();
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn('translations');
            });
        }
    }
};
