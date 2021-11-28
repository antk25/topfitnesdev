<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraceletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bracelets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('title', 300);
            $table->string('subtitle', 300)->nullable();
            $table->string('description', 1000)->nullable();
            $table->text('about')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->integer('position')->unsigned()->nullable();
            $table->float('rating_bracelet', 4, 2)->unsinged()->nullable();
            $table->float('grade_bracelet', 4, 2)->unsinged()->nullable();
            $table->decimal('avg_price', $precision = 18, $scale = 2)->nullable();
            $table->json('plus')->nullable();
            $table->json('minus')->nullable();
            $table->json('buyers_like')->nullable();
            $table->boolean('popular')->default(0);
            $table->boolean('hit')->default(0);
            $table->boolean('selection')->default(0);
            $table->integer('year')->unsinged()->nullable();
            $table->string('country')->nullable();
            $table->json('compatibility')->nullable();
            $table->string('assistant_app')->nullable();
            $table->json('material')->nullable();
            $table->boolean('replaceable_strap')->default(0);
            $table->boolean('lenght_adj')->default(0);
            $table->json('colors')->nullable();
            $table->json('protect_stand')->nullable();
            $table->json('terms_of_use')->nullable();
            $table->string('dimensions')->nullable();
            $table->float('weight', 4, 1)->unsinged()->nullable();
            $table->float('disp_diag', 4, 1)->unsinged()->nullable();
            $table->string('disp_tech', 100)->nullable();
            $table->string('disp_resolution')->nullable();
            $table->integer('disp_ppi')->unsinged()->nullable();
            $table->boolean('disp_sens')->default(0);
            $table->boolean('disp_color')->default(0);
            $table->integer('disp_brightness')->nullable()->unsinged();
            $table->integer('disp_col_depth')->nullable()->unsinged();
            $table->boolean('disp_aod')->default(0);
            $table->json('sensors')->nullable();
            $table->boolean('gps')->default(0);
            $table->boolean('vibration')->default(0);
            $table->string('blue_ver')->nullable();
            $table->boolean('nfc')->default(0)->nullable();
            $table->string('nfc_inf')->nullable();
            $table->json('other_interfaces')->nullable();
            $table->json('phone_calls')->nullable();
            $table->json('notification')->nullable();
            $table->boolean('send_messages')->default(0);
            $table->json('monitoring')->nullable();
            $table->boolean('heart_rate')->default(0);
            $table->boolean('blood_oxy')->default(0);
            $table->boolean('blood_pressure')->default(0);
            $table->boolean('stress')->default(0);
            $table->json('training_modes')->nullable();
            $table->boolean('workout_recognition')->default(0);
            $table->boolean('inactivity_reminder')->default(0);
            $table->boolean('search_smartphone')->default(0);
            $table->boolean('smart_alarm')->default(0);
            $table->boolean('camera_control')->default(0);
            $table->boolean('player_control')->default(0);
            $table->boolean('timer')->default(0);
            $table->boolean('stopwatch')->default(0);
            $table->boolean('women_calendar')->default(0);
            $table->boolean('weather_forecast')->default(0);
            $table->string('additional_info', 2000)->nullable();
            $table->string('type_battery')->nullable();
            $table->integer('capacity_battery')->nullable()->unsinged();
            $table->integer('standby_time')->nullable()->unsinged();
            $table->integer('real_time')->nullable();
            $table->integer('full_charge_time')->nullable()->unsinged();
            $table->string('charger')->nullable();
            $table->json('destination')->nullable();
            $table->boolean('published')->default(1);
            $table->timestamps();
            $table->softDeletes();
    });

}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bracelets');
    }
}
