<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletComparsionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_comparsion', function (Blueprint $table) {
           $table->foreignId('bracelet_id')->constrained();
           $table->foreignId('comparison_id')->constrained();
           $table->timestamps();

           $table->index(["bracelet_id", "comparison_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_comparsion');
    }
}
