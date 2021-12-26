<?php

namespace App\Http\Controllers\Products;

use App\Filters\CheckedAdminFilter;
use App\Filters\NameFilter;
use App\Filters\PublishedFilter;
use App\Imports\BraceletsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\{Brand, Bracelet, Rating, Review, Grade, Seller, Spec};
use Illuminate\Support\Str;
use App\Http\Requests\Admin\BraceletRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class AdminBraceletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filters = EloquentFilters::make([new CheckedAdminFilter($request->published, $request->selection),
                                          new NameFilter($request->name)
                                        ]);

        $bracelets = Bracelet::withTrashed()->with('brands')->filter($filters)->paginate(20);

        $lastfile = head(Storage::files('import'));

        // $lastfile = Storage::url($lastfile);

        return view('admin.bracelets.index', compact('bracelets', 'lastfile'));
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

        $specs = Spec::where('device', 'bracelet')->get();

        return view('admin.bracelets.create', compact('brands', 'ratings', 'grades', 'sellers', 'specs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BraceletRequest $request)
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $bracelet = Bracelet::create([
           'name' => request('name'),
           'slug' => $slug,
           'title' => request('title'),
           'subtitle' => request('subtitle'),
           'description' => request('description'),
           'about' => request('about'),
           'brand_id' => request('brand_id'),
           'position' => request('position'),
           'plus' => request('plus') ?? [],
           'minus' => request('minus') ?? [],
           'buyers_like' => request('buyers_like') ?? [],
           'popular' => $request->has('popular') ? true : false,
           'hit' => $request->has('hit') ? true : false,
           'selection' => $request->has('selection') ? true : false,
           'published' => $request->has('published') ? true : false,
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility') ?? [],
           'assistant_app' => request('assistant_app'),
           'material' => request('material') ?? [],
           'replaceable_strap' => $request->has('replaceable_strap') ? true : false,
           'lenght_adj' => $request->has('lenght_adj') ? true : false,
           'colors' => request('colors') ?? [],
           'protect_stand' => request('protect_stand') ?? [],
           'terms_of_use' => request('terms_of_use') ?? [],
           'dimensions' => request('dimensions'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => $request->has('disp_sens') ? true : false,
           'disp_color' => $request->has('disp_color') ? true : false,
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => $request->has('disp_aod') ? true : false,
           'sensors' => request('sensors') ?? [],
           'gps' => $request->has('gps') ? true : false,
           'vibration' => $request->has('vibration') ? true : false,
           'blue_ver' => request('blue_ver'),
           'nfc' => $request->has('nfc') ? true : false,
           'nfc_inf' => request('nfc_inf'),
           'other_interfaces' => request('other_interfaces') ?? [],
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification') ?? [],
           'send_messages' => $request->has('send_messages') ? true : false,
           'monitoring' => request('monitoring') ?? [],
           'heart_rate' => $request->has('heart_rate') ? true : false,
           'blood_oxy' => $request->has('blood_oxy') ? true : false,
           'blood_pressure' => $request->has('blood_pressure') ? true : false,
           'stress' => $request->has('stress') ? true : false,
           'training_modes' => request('training_modes') ?? [],
           'workout_recognition' => $request->has('workout_recognition') ? true : false,
           'inactivity_reminder' => $request->has('inactivity_reminder') ? true : false,
           'search_smartphone' => $request->has('search_smartphone') ? true : false,
           'smart_alarm' => $request->has('smart_alarm') ? true : false,
           'camera_control' => $request->has('camera_control') ? true : false,
           'player_control' => $request->has('player_control') ? true : false,
           'timer' => $request->has('timer') ? true : false,
           'stopwatch' => $request->has('stopwatch') ? true : false,
           'women_calendar' => $request->has('women_calendar') ? true : false,
           'weather_forecast' => $request->has('weather_forecast') ? true : false,
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
           'destination' => request('destination'),
           // 'avg_price' => $price_seller_avg,
           // 'grade_bracelet' => $value_grade_avg
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

        /**
         * Подготовка данных по оценкам для прикрепления их к товару
         *
         * Используется PHP функция для работы с массивами array_column
         * https://www.php.net/manual/ru/function.array-column.php
         *
         */


        $allgrades = $request->input('allgrades');

        if ($allgrades != '') {
            $grades = array_column($allgrades, 'grades');
            $value_grade = array_column($allgrades, 'value_grade');


        /**
        * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
        *
        * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
        *
        */

            for ($grade=0; $grade < count($grades); $grade++) {
                if ($grades[$grade] != '') {
                    $bracelet->grades()->attach($grades[$grade], ['value' => $value_grade[$grade]]);
                }
            }
        }


        /**
         * Подготовка данных по продавцам для прикрепления их к товару
         *
         * Используется PHP функция для работы с массивами array_column
         * https://www.php.net/manual/ru/function.array-column.php
         *
         */

        $allsellers = $request->input('allsellers');

        if ($allsellers != '') {
            $sellers = array_column($allsellers, 'sellers');
            $link_seller = array_column($allsellers, 'link_seller');
            $price_seller = array_column($allsellers, 'price_seller');
            $old_price_seller = array_column($allsellers, 'old_price_seller');


        /**
        * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
        *
        * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
        *
        */

            for ($seller=0; $seller < count($sellers); $seller++) {
                if ($sellers[$seller] != '') {
                    $bracelet->sellers()->attach($sellers[$seller], ['link' => $link_seller[$seller], 'price' => $price_seller[$seller], 'old_price' => $old_price_seller[$seller]]);
                }
            }
        }


        if ($bracelet) {
          return redirect()
                 ->route('bracelets.edit', $bracelet->id)
                 ->with(['success' => 'Новый браслет успешно добавлен. Отредактируйте данные, если нужно']);
           } else {
            return back()
                    ->withErrors(['msg' => 'Ошибка сохранения, проверьте все поля, где подсвечена ошибка'])
                    ->withInput();
           }

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

        $specs = Spec::where('device', 'bracelet')->get();

        return view('admin.bracelets.edit', compact('brands', 'bracelet', 'braceletbrand', 'ratings', 'grades', 'sellers', 'reviews', 'media', 'specs'));
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


        if (empty($bracelet)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }


        // $request->merge(["avg_price" => $avg_price]);


        // работа обсервера

        // Обновление/добавление рейтингов, в которых присутствует браслет

        $allratings = $request->input('allratings');

        // $allratings = array_filter($allratings, array($this, 'delNull'));

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

            if(!is_null($ratings[0]))
            {

                $bracelet->ratings()->sync($data);

            }

        }
        // Для того, чтобы при удалении всех рейтингов - были удалены все связи, обязательно нужен след код:
        else {
            $ratings = $bracelet->ratings->pluck('id')->all();
            $bracelet->ratings()->detach($ratings);
        }


        // Обновление/Добавление различных оценок для браслета

        $allgrades = $request->input('allgrades');

        // $allgrades = array_filter($allgrades, array($this, 'delNull'));

        if ($allgrades != '') {
            $grades = array_column($allgrades, 'grades');
            $value_grade = array_column($allgrades, 'value_grade');

            $extra2 = array_map(function($v){
                return ['value' => $v];
            }, $value_grade);

            $data2 = array_combine($grades, $extra2);


            if(!is_null($grades[0]))
            {

                $bracelet->grades()->sync($data2);
                // Вычисление среднего рейтинга по оценкам grades
                $value_grade_col = collect($value_grade);

                $value_grade_avg = $value_grade_col->avg();

                $bracelet->update([
                    'grade_bracelet' => $value_grade_avg
                ]);
            }

        }
        // Для того, чтобы при удалении всех оценок - были удалены все связи, обязательно нужен след код:
        else {
            $grades = $bracelet->grades->pluck('id')->all();
            $bracelet->grades()->detach($grades);
        }

        // Обновление/Добавление продавцов и цен для браслета

        $allsellers = $request->input('allsellers');


        // $allsellers = array_filter($allsellers, array($this, 'delNull'));

        if ($allsellers != '') {
            $sellers = array_column($allsellers, 'sellers');
            $link_seller = array_column($allsellers, 'link_seller');
            $price_seller = array_column($allsellers, 'price_seller');
            $old_price_seller = array_column($allsellers, 'old_price_seller');

            $extra3 = array_map(function($l, $p, $o){
                return ['link' => $l, 'price' => $p, 'old_price' => $o];
            }, $link_seller, $price_seller, $old_price_seller);

            $data3 = array_combine($sellers, $extra3);

            if(!is_null($sellers[0]))
            {

                $bracelet->sellers()->sync($data3);

                // Вычисление средней цены по продавцам. Будет сразу записано в соотеветствующий столбец
                $price_seller_col = collect($price_seller);

                $price_seller_avg = $price_seller_col->avg();

                $bracelet->update([
                    'avg_price' => $price_seller_avg
                ]);
            }

        }
        // Для того, чтобы при удалении всех продавцов - были удалены все связи, обязательно нужен след код:
        else {
            $sellers = $bracelet->sellers->pluck('id')->all();
            $bracelet->sellers()->detach($sellers);
        }


        $files = request('files');
        $nameimg = request('nameimg');

        if ($files != '' && isset($nameimg[0])) {
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

        $slug = $request->slug;

        $slug = Str::slug($slug, '-');


        $result = $bracelet->update([
           'name' => request('name'),
           'slug' => $slug,
           'title' => request('title'),
           'subtitle' => request('subtitle'),
           'description' => request('description'),
           'about' => request('about'),
           'brand_id' => request('brand_id'),
           'position' => request('position'),
           'plus' => request('plus') ?? [],
           'minus' => request('minus') ?? [],
           'buyers_like' => request('buyers_like') ?? [],
           'popular' => $request->has('popular') ? true : false,
           'hit' => $request->has('hit') ? true : false,
           'selection' => $request->has('selection') ? true : false,
           'published' => $request->has('published') ? true : false,
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility') ?? [],
           'assistant_app' => request('assistant_app'),
           'material' => request('material') ?? [],
           'replaceable_strap' => $request->has('replaceable_strap') ? true : false,
           'lenght_adj' => $request->has('lenght_adj') ? true : false,
           'colors' => request('colors') ?? [],
           'protect_stand' => request('protect_stand') ?? [],
           'terms_of_use' => request('terms_of_use') ?? [],
           'dimensions' => request('dimensions'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => $request->has('disp_sens') ? true : false,
           'disp_color' => $request->has('disp_color') ? true : false,
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => $request->has('disp_aod') ? true : false,
           'sensors' => request('sensors') ?? [],
           'gps' => $request->has('gps') ? true : false,
           'vibration' => $request->has('vibration') ? true : false,
           'blue_ver' => request('blue_ver'),
           'nfc' => $request->has('nfc') ? true : false,
           'nfc_inf' => request('nfc_inf'),
           'other_interfaces' => request('other_interfaces') ?? [],
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification') ?? [],
           'send_messages' => $request->has('send_messages') ? true : false,
           'monitoring' => request('monitoring') ?? [],
           'heart_rate' => $request->has('heart_rate') ? true : false,
           'blood_oxy' => $request->has('blood_oxy') ? true : false,
           'blood_pressure' => $request->has('blood_pressure') ? true : false,
           'stress' => $request->has('stress') ? true : false,
           'training_modes' => request('training_modes') ?? [],
           'workout_recognition' => $request->has('workout_recognition') ? true : false,
           'inactivity_reminder' => $request->has('inactivity_reminder') ? true : false,
           'search_smartphone' => $request->has('search_smartphone') ? true : false,
           'smart_alarm' => $request->has('smart_alarm') ? true : false,
           'camera_control' => $request->has('camera_control') ? true : false,
           'player_control' => $request->has('player_control') ? true : false,
           'timer' => $request->has('timer') ? true : false,
           'stopwatch' => $request->has('stopwatch') ? true : false,
           'women_calendar' => $request->has('women_calendar') ? true : false,
           'weather_forecast' => $request->has('weather_forecast') ? true : false,
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
           'destination' => request('destination'),
           // 'avg_price' => $price_seller_avg,
           // 'grade_bracelet' => $value_grade_avg
        ]);

        if ($result) {
          return redirect()
                 ->route('bracelets.edit', $bracelet->id)
                 ->with(['success' => 'Внесенные изменения были сохранены']);
           } else {
            return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
           }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bracelet = Bracelet::withTrashed()->find($id);

        if ($bracelet->trashed())
            {
                $bracelet->forceDelete();
            }
        else
            {
                $bracelet->delete();
            }


        return back();
    }

    public function restore($id)
    {

        $bracelet = Bracelet::onlyTrashed()->find($id);

        $bracelet->restore();

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

    protected function gradeUpdate() {

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

    public function import(Request $request)
    {

       $request->validate([
        'importFile' => 'required',
       ]);

       $file = $request->file('importFile')->store('import');

    //    $import = new BraceletsImport();

    //    $import->import($file);

       Excel::import(new BraceletsImport, $file);



    //    if ($import->failures()->isNotEmpty())
    //    {
    //        return back()->withFailures($import->failures());
    //    }


       return back()->with('success', 'Завершено!');
    }

    // private function delNull($item)
    // {
    //     return $item != null;
    // }
}

