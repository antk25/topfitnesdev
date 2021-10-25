<?php

namespace App\Http\Controllers\Admin;
use App\Imports\BraceletsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Bracelet;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Grade;
use App\Models\Seller;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\BraceletRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BraceletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bracelets = Bracelet::with('brands')->paginate(20);

        return view('admin.bracelets.index', compact('bracelets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id')->all();

        $ratings = Rating::pluck('title', 'id')->all();

        $grades = Grade::pluck('name', 'id')->all();

        $sellers = Seller::pluck('name', 'id')->all();

        return view('admin.bracelets.create', compact('brands', 'ratings', 'grades', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BraceletRequest $request)
    {

        $bracelet = Bracelet::create([
           'name' => request('name'),
           'slug' => request('slug'),
           'title' => request('title'),
           'subtitle' => request('subtitle'),
           'description' => request('description'),
           'about' => request('about'),
           'brand_id' => request('brand_id'),
           'position' => request('position'),
           'plus' => request('plus'),
           'minus' => request('minus'),
           'buyers_like' => request('buyers_like'),
           'popular' => request('popular') == 'on' ? '1' : '0',
           'hit' => request('hit') == 'on' ? '1' : '0',
           'selection' => request('selection') == 'on' ? '1' : '0',
           'published' => request('published') == 'on' ? '1' : '0',
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility'),
           'assistant_app' => request('assistant_app'),
           'material' => request('material'),
           'replaceable_strap' => request('replaceable_strap') == 'on' ? '1' : '0',
           'lenght_adj' => request('lenght_adj') == 'on' ? '1' : '0',
           'colors' => request('colors'),
           'protect_stand' => request('protect_stand'),
           'terms_of_use' => request('terms_of_use'),
           'dimensions' => request('dimensions'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => request('disp_sens') == 'on' ? '1' : '0',
           'disp_color' => request('disp_color') == 'on' ? '1' : '0',
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => request('disp_aod') == 'on' ? '1' : '0',
           'sensors' => request('sensors'),
           'gps' => request('gps') == 'on' ? '1' : '0',
           'vibration' => request('vibration') == 'on' ? '1' : '0',
           'blue_ver' => request('blue_ver'),
           'nfc' => request('nfc'),
           'other_interfaces' => request('other_interfaces'),
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification'),
           'send_messages' => request('send_messages'),
           'monitoring' => request('monitoring'),
           'heart_rate' => request('heart_rate') == 'on' ? '1' : '0',
           'blood_oxy' => request('blood_oxy') == 'on' ? '1' : '0',
           'blood_pressure' => request('blood_pressure') == 'on' ? '1' : '0',
           'stress' => request('stress') == 'on' ? '1' : '0',
           'training_modes' => request('training_modes'),
           'workout_recognition' => request('workout_recognition') == 'on' ? '1' : '0',
           'inactivity_reminder' => request('inactivity_reminder') == 'on' ? '1' : '0',
           'search_smartphone' => request('search_smartphone') == 'on' ? '1' : '0',
           'smart_alarm' => request('smart_alarm') == 'on' ? '1' : '0',
           'camera_control' => request('camera_control') == 'on' ? '1' : '0',
           'player_control' => request('player_control') == 'on' ? '1' : '0',
           'timer' => request('timer') == 'on' ? '1' : '0',
           'stopwatch' => request('stopwatch') == 'on' ? '1' : '0',
           'women_calendar' => request('women_calendar') == 'on' ? '1' : '0',
           'weather_forecast' => request('weather_forecast') == 'on' ? '1' : '0',
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
        ]);

        $files = request('files');

        if ($files != '') {
            $lastbracelet = Bracelet::find($bracelet->id);
            $i = 0;
            foreach ($files as $file) {
                $lastbracelet->addMedia($file)
                    ->toMediaCollection('bracelet');
            }
        }

        /**
         * Подготовка данных по рейтингам для прикрепления их к товару
         *
         * Используется PHP функция для работы с массивами array_column
         * https://www.php.net/manual/ru/function.array-column.php
         *
         */

        $allratings = $request->input('allratings');

        if ($allratings != '') {
            $ratings = array_column($allratings, 'ratings');
            $position_rating = array_column($allratings, 'position_rating');
            $text_rating = array_column($allratings, 'text_rating');
            $head_rating = array_column($allratings, 'head_rating');

            /**
            * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
            *
            * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
            *
            */

            for ($rating=0; $rating < count($ratings); $rating++) {

                    $bracelet->ratings()->attach($ratings[$rating], ['position' => $position_rating[$rating], 'text_rating' => $text_rating[$rating], 'head_rating' => $head_rating[$rating]]);

            }
        }


        $allgrades = $request->input('allgrades');

        if ($allgrades != '') {
            $grades = array_column($allgrades, 'grades');
            $position_grade = array_column($allgrades, 'position_grade');
            $value_grade = array_column($allgrades, 'value_grade');

            for ($grade=0; $grade < count($grades); $grade++) {
                if ($grades[$grade] != '') {
                    $bracelet->grades()->attach($grades[$grade], ['position' => $position_grade[$grade], 'value' => $value_grade[$grade]]);
                }
            }
        }

        $allsellers = $request->input('allsellers');

        if ($allsellers != '') {
            $sellers = array_column($allsellers, 'sellers');
            $link_seller = array_column($allsellers, 'link_seller');
            $price_seller = array_column($allsellers, 'price_seller');
            $old_price_seller = array_column($allsellers, 'old_price_seller');

            for ($seller=0; $seller < count($sellers); $seller++) {
                if ($sellers[$seller] != '') {
                    $bracelet->sellers()->attach($sellers[$seller], ['link' => $link_seller[$seller], 'price' => $price_seller[$seller], 'old_price' => $old_price_seller[$seller]]);
                }
            }
        }



        return redirect()->route('bracelets.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bracelet = Bracelet::with('reviews')->find($id);

        $braceletbrand = Brand::where('id', $bracelet->brand_id)->select('name')->first();

        $brands = Brand::pluck('name', 'id')->all();

        $ratings = Rating::pluck('title', 'id')->all();

        $grades = Grade::pluck('name', 'id')->all();

        $sellers = Seller::pluck('name', 'id')->all();

        $reviews = $bracelet->reviews()->paginate(20);

        $media = $bracelet->getMedia('bracelet');

        return view('admin.bracelets.edit', compact('brands', 'bracelet', 'braceletbrand', 'ratings', 'grades', 'sellers', 'reviews', 'media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BraceletRequest $request, $id)
    {

        $bracelet = Bracelet::find($id);


        $allratings = $request->input('allratings');

        if ($allratings != '') {
            $ratings = array_column($allratings, 'ratings');
            $position_rating = array_column($allratings, 'position_rating');
            $text_rating = array_column($allratings, 'text_rating');
            $head_rating = array_column($allratings, 'head_rating');

            /**
            * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
            *
            * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
            *
            */

            $extra = array_map(function($p, $t, $h){
                return ['position' => $p, 'text_rating' => $t, 'head_rating' => $h];
            }, $position_rating, $text_rating, $head_rating);

            $data = array_combine($ratings, $extra);

            $bracelet->ratings()->sync($data);
        }
        // Для того, чтобы при удалении всех рейтингов - были удалены все связи, обязательно нужен след код:
        else {
            $ratings = $bracelet->ratings->pluck('id')->all();
            $bracelet->ratings()->detach($ratings);
        }


        $allgrades = $request->input('allgrades');

        if ($allgrades != '') {
            $grades = array_column($allgrades, 'grades');
            $position_grade = array_column($allgrades, 'position_grade');
            $value_grade = array_column($allgrades, 'value_grade');

            $extra2 = array_map(function($v, $p){
                return ['value' => $v, 'position' => $p];
            }, $value_grade, $position_grade);

            $data2 = array_combine($grades, $extra2);

            $bracelet->grades()->sync($data2);

        }
        // Для того, чтобы при удалении всех оценок - были удалены все связи, обязательно нужен след код:
        else {
            $grades = $bracelet->grades->pluck('id')->all();
            $bracelet->grades()->detach($grades);
        }

        $allsellers = $request->input('allsellers');

        if ($allsellers != '') {
            $sellers = array_column($allsellers, 'sellers');
            $link_seller = array_column($allsellers, 'link_seller');
            $price_seller = array_column($allsellers, 'price_seller');
            $old_price_seller = array_column($allsellers, 'old_price_seller');

            $extra3 = array_map(function($l, $p, $o){
                return ['link' => $l, 'price' => $p, 'old_price' => $o];
            }, $link_seller, $price_seller, $old_price_seller);

            $data3 = array_combine($sellers, $extra3);

            $bracelet->sellers()->sync($data3);
        }
        // Для того, чтобы при удалении всех продавцов - были удалены все связи, обязательно нужен след код:
        else {
            $sellers = $bracelet->sellers->pluck('id')->all();
            $bracelet->sellers()->detach($sellers);
        }

        // Вычисление средней цены по продавцам
        $avg_price = collect($request->price);

        $avg_price = $avg_price->avg();

        // Вычисление среднего рейтинга по оценкам grades
        $avg_grade = collect($request->value);

        $avg_grade = $avg_grade->avg();

        $bracelet->update([
           'name' => request('name'),
           'slug' => request('slug'),
           'title' => request('title'),
           'subtitle' => request('subtitle'),
           'description' => request('description'),
           'about' => request('about'),
           'brand_id' => request('brand_id'),
           'position' => request('position'),
           'plus' => request('plus'),
           'minus' => request('minus'),
           'buyers_like' => request('buyers_like'),
           'popular' => request('popular') == 'on' ? '1' : '0',
           'hit' => request('hit') == 'on' ? '1' : '0',
           'selection' => request('selection') == 'on' ? '1' : '0',
           'published' => request('published') == 'on' ? '1' : '0',
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility'),
           'assistant_app' => request('assistant_app'),
           'material' => request('material'),
           'replaceable_strap' => request('replaceable_strap') == 'on' ? '1' : '0',
           'lenght_adj' => request('lenght_adj') == 'on' ? '1' : '0',
           'colors' => request('colors'),
           'protect_stand' => request('protect_stand'),
           'terms_of_use' => request('terms_of_use'),
           'dimensions' => request('dimensions'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => request('disp_sens') == 'on' ? '1' : '0',
           'disp_color' => request('disp_color') == 'on' ? '1' : '0',
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => request('disp_aod') == 'on' ? '1' : '0',
           'sensors' => request('sensors'),
           'gps' => request('gps') == 'on' ? '1' : '0',
           'vibration' => request('vibration') == 'on' ? '1' : '0',
           'blue_ver' => request('blue_ver'),
           'nfc' => request('nfc'),
           'other_interfaces' => request('other_interfaces'),
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification'),
           'send_messages' => request('send_messages'),
           'monitoring' => request('monitoring'),
           'heart_rate' => request('heart_rate') == 'on' ? '1' : '0',
           'blood_oxy' => request('blood_oxy') == 'on' ? '1' : '0',
           'blood_pressure' => request('blood_pressure') == 'on' ? '1' : '0',
           'stress' => request('stress') == 'on' ? '1' : '0',
           'training_modes' => request('training_modes'),
           'workout_recognition' => request('workout_recognition') == 'on' ? '1' : '0',
           'inactivity_reminder' => request('inactivity_reminder') == 'on' ? '1' : '0',
           'search_smartphone' => request('search_smartphone') == 'on' ? '1' : '0',
           'smart_alarm' => request('smart_alarm') == 'on' ? '1' : '0',
           'camera_control' => request('camera_control') == 'on' ? '1' : '0',
           'player_control' => request('player_control') == 'on' ? '1' : '0',
           'timer' => request('timer') == 'on' ? '1' : '0',
           'stopwatch' => request('stopwatch') == 'on' ? '1' : '0',
           'women_calendar' => request('women_calendar') == 'on' ? '1' : '0',
           'weather_forecast' => request('weather_forecast') == 'on' ? '1' : '0',
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
           'avg_price' => $avg_price,
           'grade_bracelet' => $avg_grade
        ]);

        $files = request('files');
        $nameimg = request('nameimg');

        if ($files != '' && $nameimg[0] != '') {
            $lastbracelet = Bracelet::find($bracelet->id);
            $i = 0;
            foreach ($files as $file) {
                $lastbracelet->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('bracelet');
            }
        }
        elseif ($files != '') {
            $lastbracelet = Bracelet::find($bracelet->id);
            foreach ($files as $file) {
                $lastbracelet->addMedia($file)
                    ->toMediaCollection('bracelet');
            }
        }


        return redirect()->route('bracelets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bracelet::destroy($id);

        return back();
    }


    public function imgdelete(Request $request) {

        $imgid = $request->imgid;

        $mediaItems = Media::find($imgid);

        $mediaItems->delete();

        return back();

    }

    public function imgupdate(Request $request) {

        $id = $request->imgid;

        $image = Media::find($id);

        $image->update([
            'name' => request('nameimg')
        ]);

        return back();

    }

    public function gradeUpdate() {

        $bracelets = Bracelet::with('grades')->select('id')->get();

        foreach ($bracelets as $bracelet)
        {
           $brgrade = DB::table('bracelet_grade')->where('bracelet_id', $bracelet->id)->pluck('value');

           $brgrade = $brgrade->avg();

           $bracelet->update([
               'grade_bracelet' => $brgrade
           ]);
        }

        return back();

    }

    public function import()
    {
        Excel::import(new BraceletsImport, 'all_bracelets_1.xlsx');

        return back()->with('success', 'Завершено!');
    }
}

