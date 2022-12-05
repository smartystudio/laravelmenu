<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_items'))) {
            Schema::create(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_items'), function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('label');
                $table->string('link');
                $table->string('icon')->nullable();
                $table->unsignedBigInteger('parent')->default(0);
                $table->integer('sort')->default(0);
                $table->string('class')->nullable();
                $table->enum('target', ['_self', '_blank'])->default('_self');
                $table->unsignedBigInteger('menu');
                $table->integer('depth')->default(0);
                $table->timestamps();

                $table->foreign('menu')->references('id')->on(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_menus'))
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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
        Schema::dropIfExists(config('laravelmenu.table_prefix') . config('laravelmenu.table_name_items'));
    }
}
