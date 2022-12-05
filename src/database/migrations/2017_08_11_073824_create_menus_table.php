<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'))) {
            Schema::create(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'));
    }
}
