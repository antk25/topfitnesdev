<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletComparisonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_comparison', function (Blueprint $table) {
           $table->unsignedBigInteger('bracelet_id');
           $table->unsignedBigInteger('comparison_id');
           $table->timestamps();

           $table->index(["bracelet_id", "comparison_id"]);

           $table->foreign('bracelet_id')->references('id')->on('bracelets')->onDelete('cascade')->onUpdate('cascade');
           $table->foreign('comparison_id')->references('id')->on('comparisons')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_comparison');
    }
}
