<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('bracelet_id')->unsinged();
            $table->string('name', 100);
            $table->string('email', 100)->nullable();
            $table->string('period_use')->nullable();
            $table->integer('rating_user')->unsinged()->nullable();
            $table->text('review_text');
            $table->json('what_like')->nullable();
            $table->json('what_nolike')->nullable();
            $table->integer('votes_review')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
