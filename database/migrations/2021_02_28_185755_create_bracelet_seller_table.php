<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_seller', function (Blueprint $table) {
            $table->unsignedBigInteger('bracelet_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('link')->nullable();
            $table->decimal('price', $precision = 18, $scale = 2)->nullable();
            $table->decimal('old_price', $precision = 18, $scale = 2)->nullable();
            $table->index(["bracelet_id", "seller_id"]);

            $table->foreign('bracelet_id')->references('id')->on('bracelets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_seller');
    }
}
