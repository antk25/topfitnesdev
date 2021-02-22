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
            $table->id();
            $table->integer('bracelet_id')->unsinged();
            $table->integer('rating_id')->unsinged();
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
