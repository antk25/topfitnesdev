<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_rating', function (Blueprint $table) {
            $table->foreignId('bracelet_id')->constrained();
            $table->foreignId('rating_id')->constrained();
            $table->integer('position')->unsinged()->nullable();
            $table->timestamps();

            $table->index(["bracelet_id", "rating_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_rating');
    }
}
