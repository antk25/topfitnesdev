<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAndAddColumnsToBraceletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bracelets', function (Blueprint $table) {
           $table->renameColumn('grade_bracelet', 'average_grade');
           $table->dropColumn('rating_bracelet');
           $table->float('average_pressure_grade', 4, 2)->nullable()->unsigned()->after('grade_bracelet');
           $table->float('average_smart_grade', 4, 2)->nullable()->unsigned()->after('grade_bracelet');
           $table->float('average_pedometer_grade', 4, 2)->nullable()->unsigned()->after('grade_bracelet');
           $table->float('average_pulse_grade', 4, 2)->nullable()->unsigned()->after('grade_bracelet');
           $table->float('average_swim_grade', 4, 2)->nullable()->unsigned()->after('grade_bracelet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bracelets', function (Blueprint $table) {
           $table->renameColumn('average_grade', 'grade_bracelet');
           $table->float('rating_bracelet', 4,2)->nullable();
           $table->dropColumn('average_pressure_grade');
           $table->dropColumn('average_smart_grade');
           $table->dropColumn('average_pedometer_grade');
           $table->dropColumn('average_pulse_grade');
           $table->dropColumn('average_swim_grade');
        });
    }
}
