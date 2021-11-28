<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelet_grade', function (Blueprint $table) {
            $table->foreignId('bracelet_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->float('value', 3, 2);
            $table->index(["bracelet_id", "grade_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelet_grade');
    }
}
