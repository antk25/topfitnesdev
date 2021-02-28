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
            $table->foreignId('bracelet_id')->constrained();
            $table->foreignId('seller_id')->constrained();
            $table->string('link')->nullable();
            $table->decimal('price', $precision = 18, $scale = 2)->nullable();
            $table->decimal('old_price', $precision = 18, $scale = 2)->nullable(); 
            $table->index(["bracelet_id", "seller_id"]);
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
