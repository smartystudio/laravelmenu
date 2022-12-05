<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassToMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'), function (Blueprint $table) {
            $table->string('class')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'), function ($table) {
            $table->dropColumn('class');
        });
    }
}
