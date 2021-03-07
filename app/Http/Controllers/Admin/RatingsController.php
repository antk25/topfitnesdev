<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Bracelet;
use App\Http\Requests\Admin\RatingRequest;
use Illuminate\Support\Str;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ratings = Rating::paginate(20);
        
        return view('admin.ratings.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.ratings.create', compact('bracelets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {

        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        $rating = Rating::create([
                    'subtitle' => request('subtitle'),
                    'name' => request('name'),
                    'slug' => $slug,
                    'title' => request('title'),
                    'description' => request('description'),
                    'text' => request('text')
                ]);

        $bracelets = $request->input('bracelets', []);

        $position = $request->input('position', []);

        $text_rating = $request->input('text_rating', []);

        for ($bracelet=0; $bracelet < count($bracelets); $bracelet++) {
            if ($bracelets[$bracelet] != '') {
                $rating->bracelets()->attach($bracelets[$bracelet], ['position' => $position[$bracelet], 'text_rating' => $text_rating[$bracelet]]);
            }
        }

        // if($request->files) {

        // $files = request('files');

        // $lastrating = Rating::find($rating->id);

        // foreach ($files as $file) {
        //     $lastrating->addMedia($file)
        //         ->toMediaCollection('ratings');
        // }

        // }

        return redirect()->route('ratings.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rating = Rating::with('bracelets')->find($id);

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.ratings.edit', compact('rating', 'bracelets'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RatingRequest $request, $id)
    {
        $rating = Rating::find($id);

        $bracelets = $request->bracelets;

        $position = $request->position;

        $text_rating = $request->text_rating;

        $extra = array_map(function($p, $r){
            return ['position' => $p, 'text_rating' => $r];
        }, $position, $text_rating);

        $data = array_combine($bracelets, $extra);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $rating->update([
            'subtitle' => request('subtitle'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'text' => request('text')
        ]);



        $rating->bracelets()->sync($data);

        return redirect()->route('ratings.index');
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

        return redirect()->route('ratings.index');
    }
}
