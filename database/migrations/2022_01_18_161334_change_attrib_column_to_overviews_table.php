<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttribColumnToOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('overviews', function (Blueprint $table) {
           $table->string('description', '1000')->nullable()->change();
           $table->mediumText('content')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('overviews', function (Blueprint $table) {
           $table->string('description', '200')->nullable()->change();
           $table->text('content')->nullable()->change();
        });
    }
}
