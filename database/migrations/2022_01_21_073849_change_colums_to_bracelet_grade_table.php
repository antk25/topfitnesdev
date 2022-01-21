<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumsToBraceletGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bracelet_grade', function (Blueprint $table) {
           $table->float('value', '4', '2')->change()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bracelet_grade', function (Blueprint $table) {
            $table->float('value', '3', '2')->change();
        });
    }
}
