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

        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        $bracelet = Bracelet::create([
                    'name' => request('name'),
                    'slug' => $slug,
                    'title' => request('title'),
                    'description' => request('description'),
                    'brand_id' => request('brand_id'),
                    'year' => request('year'),
                    'country' => request('country'),
                    'compatibility' => request('compatibility'),
                    'assistant_app' => request('assistant_app'),
                    'material' => request('material')
                ]);

        $files = request('files');

        if ($files != '') {
            $lastbracelet = Bracelet::find($bracelet->id);

        foreach ($files as $file) {
            $lastbracelet->addMedia($file)
                ->toMediaCollection();
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return view('admin.bracelets.edit', compact('brands', 'bracelet', 'braceletbrand', 'ratings', 'grades', 'sellers', 'reviews'));
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


        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $bracelet->update([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'brand_id' => request('brand_id'),
            'year' => request('year'),
            'country' => request('country'),
            'compatibility' => request('compatibility'),
            'assistant_app' => request('assistant_app'),
            'material' => request('material')
        ]);



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
        // $brand = Brand::find($id);
        // $brand->delete();

        return redirect()->route('bracelets.index');
    }
}
