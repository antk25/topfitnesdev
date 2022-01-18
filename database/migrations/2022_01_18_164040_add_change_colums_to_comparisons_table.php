<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangeColumsToComparisonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comparisons', function (Blueprint $table) {
            $table->string('description', 1000)->change();
            $table->mediumText('content')->change();

            $table->string('type_table')->nullable()->after('content');
            $table->json('list_specs')->after('content');
            $table->mediumText('content_raw')->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comparisons', function (Blueprint $table) {
           $table->string('description', 300)->change();
           $table->text('content')->change();
           $table->dropColumn('type_table');
           $table->dropColumn('list_specs');
           $table->dropColumn('content_raw');
        });
    }
}
