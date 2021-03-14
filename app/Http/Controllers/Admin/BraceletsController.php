<?php

namespace App\Http\Controllers\Admin;

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
        // dd($bracelets);
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

        // dd($request->replaceable_strap);
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

        $nameimg = request('nameimg');
        
        if ($files != '') {
            $lastbracelet = Bracelet::find($bracelet->id);
            $i = 0;
            foreach ($files as $file) {
                $lastbracelet->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('bracelet');
            }
        }

        $ratings = $request->input('ratings', []);

        $position = $request->input('position', []);

        $text_rating = $request->input('text_rating', []);


        $grades = $request->input('grades', []);

        $position_grade = $request->input('position_grade', []);

        $value = $request->input('value', []);



        $sellers = $request->input('sellers', []);

        $link = $request->input('link', []);

        $price = $request->input('price', []);

        $old_price = $request->input('old_price', []);


        for ($rating=0; $rating < count($ratings); $rating++) {
            if ($ratings[$rating] != '') {
                $bracelet->ratings()->attach($ratings[$rating], ['position' => $position[$rating], 'text_rating' => $text_rating[$rating]]);
            }
        }

        for ($grade=0; $grade < count($grades); $grade++) {
            if ($grades[$grade] != '') {
                $bracelet->grades()->attach($grades[$grade], ['position' => $position_grade[$grade], 'value' => $value[$grade]]);
            }
        }

        for ($seller=0; $seller < count($sellers); $seller++) {
            if ($sellers[$seller] != '') {
                $bracelet->sellers()->attach($sellers[$seller], ['link' => $link[$seller], 'price' => $price[$seller], 'old_price' => $old_price[$seller]]);
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

        $ratings = $request->ratings;

        $position = $request->position;

        $text_rating = $request->text_rating;


        $grades = $request->grades;

        $value = $request->value;

        $position_grade = $request->position_grade;


        $sellers = $request->sellers;

        $link = $request->link;

        $price = $request->price;

        $old_price = $request->old_price;

        if ($ratings != '') {

            $extra = array_map(function($p, $r){
                return ['position' => $p, 'text_rating' => $r];
            }, $position, $text_rating);

            $data = array_combine($ratings, $extra);

            $bracelet->ratings()->sync($data);
        }

        if ($grades != '') {
            $extra2 = array_map(function($p, $r){
                return ['value' => $p, 'position' => $r];
            }, $value, $position_grade);

            $data2 = array_combine($grades, $extra2);

            $bracelet->grades()->sync($data2);
        }

        if ($sellers != '') {
            $extra3 = array_map(function($p, $r, $s){
                return ['link' => $p, 'price' => $r, 'old_price' => $s];
            }, $link, $price, $old_price);

            $data3 = array_combine($sellers, $extra3);

            $bracelet->sellers()->sync($data3);
        }

        $avg_price = collect($request->price);
        $avg_price = $avg_price->avg();

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
           'avg_price' => $avg_price
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

        return redirect()->route('bracelets.index');
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
}
