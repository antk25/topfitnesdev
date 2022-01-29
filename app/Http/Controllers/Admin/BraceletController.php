<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BraceletExport;
use App\Filters\CheckedAdminFilter;
use App\Filters\NameFilter;
use App\Filters\PublishedFilter;
use App\Imports\BraceletsImport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Bracelet;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Grade;
use App\Models\Seller;
use App\Models\Spec;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\BraceletRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;


class BraceletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {

        $filters = EloquentFilters::make([new CheckedAdminFilter($request->published, $request->selection),
                                          new NameFilter($request->name)
                                        ]);

        $bracelets = Bracelet::withTrashed()->with('brand')->filter($filters)->paginate(20);

        return view('admin.bracelets.index', compact('bracelets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     *
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
     * @param BraceletRequest $request
     * @return RedirectResponse
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
           'popular' => $request->boolean('popular'),
           'hit' => $request->boolean('hit'),
           'selection' => $request->boolean('selection'),
           'published' => $request->boolean('published'),
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility') ?? [],
           'assistant_app' => request('assistant_app'),
           'material' => request('material') ?? [],
           'replaceable_strap' => $request->boolean('replaceable_strap'),
           'lenght_adj' => $request->boolean('lenght_adj'),
           'colors' => request('colors') ?? [],
           'protect_stand' => request('protect_stand') ?? [],
           'terms_of_use' => request('terms_of_use') ?? [],
           'dimensions' => request('dimensions'),
           'weight' => request('weight'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => $request->boolean('disp_sens'),
           'disp_color' => $request->boolean('disp_color'),
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => $request->boolean('disp_aod'),
           'sensors' => request('sensors') ?? [],
           'gps' => $request->boolean('gps'),
           'vibration' => $request->boolean('vibration'),
           'blue_ver' => request('blue_ver'),
           'nfc' => $request->boolean('nfc'),
           'nfc_inf' => request('nfc_inf'),
           'other_interfaces' => request('other_interfaces') ?? [],
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification') ?? [],
           'send_messages' => $request->boolean('send_messages'),
           'monitoring' => request('monitoring') ?? [],
           'heart_rate' => $request->boolean('heart_rate'),
           'blood_oxy' => $request->boolean('blood_oxy'),
           'blood_pressure' => $request->boolean('blood_pressure'),
           'stress' => $request->boolean('stress'),
           'training_modes' => request('training_modes') ?? [],
           'workout_recognition' => $request->boolean('workout_recognition'),
           'inactivity_reminder' => $request->boolean('inactivity_reminder'),
           'search_smartphone' => $request->boolean('search_smartphone'),
           'smart_alarm' => $request->boolean('smart_alarm'),
           'camera_control' => $request->boolean('camera_control'),
           'player_control' => $request->boolean('player_control'),
           'timer' => $request->boolean('timer'),
           'stopwatch' => $request->boolean('stopwatch'),
           'women_calendar' => $request->boolean('women_calendar'),
           'weather_forecast' => $request->boolean('weather_forecast'),
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
           'destination' => request('destination') ?? [],
           // 'avg_price' => $price_seller_avg,
           // 'grade_bracelet' => $value_grade_avg
        ]);

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $bracelet->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('bracelets');
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

        if ($allratings != '')
        {
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


        if ($bracelet != null)
        {
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

        $media = $bracelet->getMedia('bracelets');

        $specs = Spec::where('device', 'bracelet')->get();

        return view('admin.bracelets.edit', compact('brands', 'bracelet', 'braceletbrand', 'ratings', 'grades', 'sellers', 'reviews', 'media', 'specs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
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

        if ($files != '') {
            foreach ($files as $file) {
                $bracelet->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('bracelets');
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
           'popular' => $request->boolean('popular'),
           'hit' => $request->boolean('hit'),
           'selection' => $request->boolean('selection'),
           'published' => $request->boolean('published'),
           'year' => request('year'),
           'country' => request('country'),
           'compatibility' => request('compatibility') ?? [],
           'assistant_app' => request('assistant_app'),
           'material' => request('material') ?? [],
           'replaceable_strap' => $request->boolean('replaceable_strap'),
           'lenght_adj' => $request->boolean('lenght_adj'),
           'colors' => request('colors') ?? [],
           'protect_stand' => request('protect_stand') ?? [],
           'terms_of_use' => request('terms_of_use') ?? [],
           'dimensions' => request('dimensions'),
            'weight' => request('weight'),
           'disp_diag' => request('disp_diag'),
           'disp_tech' => request('disp_tech'),
           'disp_resolution' => request('disp_resolution'),
           'disp_ppi' => request('disp_ppi'),
           'disp_sens' => $request->boolean('disp_sens'),
           'disp_color' => $request->boolean('disp_color'),
           'disp_brightness' => request('disp_brightness'),
           'disp_col_depth' => request('disp_col_depth'),
           'disp_aod' => $request->boolean('disp_aod'),
           'sensors' => request('sensors') ?? [],
           'gps' => $request->boolean('gps'),
           'vibration' => $request->boolean('vibration'),
           'blue_ver' => request('blue_ver'),
           'nfc' => $request->boolean('nfc'),
           'nfc_inf' => request('nfc_inf'),
           'other_interfaces' => request('other_interfaces') ?? [],
           'phone_calls' => request('phone_calls'),
           'notification' => request('notification') ?? [],
           'send_messages' => $request->boolean('send_messages'),
           'monitoring' => request('monitoring') ?? [],
           'heart_rate' => $request->boolean('heart_rate'),
           'blood_oxy' => $request->boolean('blood_oxy'),
           'blood_pressure' => $request->boolean('blood_pressure'),
           'stress' => $request->boolean('stress'),
           'training_modes' => request('training_modes') ?? [],
           'workout_recognition' => $request->boolean('workout_recognition'),
           'inactivity_reminder' => $request->boolean('inactivity_reminder'),
           'search_smartphone' => $request->boolean('search_smartphone'),
           'smart_alarm' => $request->boolean('smart_alarm'),
           'camera_control' => $request->boolean('camera_control'),
           'player_control' => $request->boolean('player_control'),
           'timer' => $request->boolean('timer'),
           'stopwatch' => $request->boolean('stopwatch'),
           'women_calendar' => $request->boolean('women_calendar'),
           'weather_forecast' => $request->boolean('weather_forecast'),
           'additional_info' => request('additional_info'),
           'type_battery' => request('type_battery'),
           'capacity_battery' => request('capacity_battery'),
           'standby_time' => request('standby_time'),
           'real_time' => request('real_time'),
           'full_charge_time' => request('full_charge_time'),
           'charger' => request('charger'),
           'destination' => request('destination') ?? [],
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

           $bracelet->grade_bracelet = $brgrade;

           $bracelet->save();

        }

        return back();

    }

    public function import(Request $request)
    {

       $request->validate([
        'importFile' => 'required',
       ]);

       $file = $request->file('importFile');

       Excel::import(new BraceletsImport, $file);

    //    if ($import->failures()->isNotEmpty())
    //    {
    //        return back()->withFailures($import->failures());
    //    }


       return back()->with('success', 'Завершено!');
    }

    public function export()
    {
        return new BraceletExport;
    }
}

