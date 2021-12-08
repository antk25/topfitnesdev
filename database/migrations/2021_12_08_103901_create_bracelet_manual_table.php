<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_manual', function (Blueprint $table) {

           $table->unsignedBigInteger('bracelet_id');
           $table->unsignedBigInteger('manual_id');
           $table->timestamps();

           $table->index(["bracelet_id", "manual_id"]);

           $table->foreign('bracelet_id')->references('id')->on('bracelets')->onDelete('cascade')->onUpdate('cascade');
           $table->foreign('manual_id')->references('id')->on('manuals')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_manual');
    }
}
