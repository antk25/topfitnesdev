<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompareItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compare_items', function (Blueprint $table) {
            $table->id();
            $table->integer('bracelet_id')->unsigned();
            $table->integer('comparison_id')->unsigned();
            $table->integer('position')->unsigned()->nullable();
            $table->string('name');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compare_items');
    }
}
