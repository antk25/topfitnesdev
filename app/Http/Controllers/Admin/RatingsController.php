<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Bracelet;
use App\Http\Requests\Admin\RatingRequest;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $lastrating = Rating::find($rating->id);
            $i = 0;
            foreach ($files as $file) {
                $lastrating->addMedia($file)
                    ->toMediaCollection('rating');
            }
        }


        /**
         * Подготовка данных по товарам для прикрепления их к рейтингу
         *
         * Используется PHP функция для работы с массивами array_column
         * https://www.php.net/manual/ru/function.array-column.php
         *
         */

        $allbracelets = $request->input('allbracelets');

        if ($allbracelets != '') {
            $bracelets = array_column($allbracelets, 'bracelets');
            $position_rating = array_column($allbracelets, 'position_rating');
            $text_rating = array_column($allbracelets, 'text_rating');
            $head_rating = array_column($allbracelets, 'head_rating');

            /**
            * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
            *
            * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
            *
            */

            for ($bracelet=0; $bracelet < count($bracelets); $bracelet++) {

                $rating->bracelets()->attach($bracelets[$bracelet], ['position' => $position_rating[$bracelet], 'text_rating' => $text_rating[$bracelet], 'head_rating' => $head_rating[$bracelet]]);

            }


        }


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

        $media = $rating->getMedia('rating');

        return view('admin.ratings.edit', compact('rating', 'bracelets', 'media'));
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


        // $bracelets = $request->bracelets;

        // $position_rating = $request->position_rating;

        // $text_rating = $request->text_rating;

        // $extra = array_map(function($p, $r){
            // return ['position' => $p, 'text_rating' => $r];
        // }, $position_rating, $text_rating);

        // $data = array_combine($bracelets, $extra);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $rating->update([
            'subtitle' => request('subtitle'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'text' => request('text')
        ]);


        $allbracelets = $request->input('allbracelets');

        if (count($allbracelets)) {
            $bracelets = array_column($allbracelets, 'bracelets');
            $position_rating = array_column($allbracelets, 'position_rating');
            $text_rating = array_column($allbracelets, 'text_rating');
            $head_rating = array_column($allbracelets, 'head_rating');

            if(!is_null($bracelets[0]))
            {
                /**
                * Перебор подготовленных данных в цикле для правильной передачи их функции Laravel attach()
                *
                * https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships
                *
                */

                $extra = array_map(function($p, $t, $h){
                    return ['position' => $p, 'text_rating' => $t, 'head_rating' => $h];
                }, $position_rating, $text_rating, $head_rating);

                $data = array_combine($bracelets, $extra);

                $rating->bracelets()->sync($data);
            }


        }
        // Для того, чтобы при удалении всех браслетов - были удалены все связи, обязательно нужен след код:
        else {
            $bracelets = $rating->bracelets->pluck('id')->all();
            $rating->bracelets()->detach($bracelets);
        }


        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $lastrating = Rating::find($rating->id);
            $i = 0;
            foreach ($files as $file) {
                $lastrating->addMedia($file)
                    ->toMediaCollection('rating');
            }
        }


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
        Rating::destroy($id);

        return back();
    }

}
