<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Bracelet;
use App\Http\Requests\Admin\RatingRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RatingController extends Controller
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


    public function publish($id)
    {
        $rating = Rating::find($id);

        if ($rating->published)
        {
            $rating->published = false;
        }
        else
        {
            $rating->published = true;
        }

        $rating->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $bracelets = Bracelet::pluck('name', 'id')->all();

        $users = User::pluck('name', 'id')->all();

        return view('admin.ratings.create', compact('bracelets', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingRequest $request)
    {

        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $rating = Rating::create([
                    'user_id' => request('user_id'),
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $rating = Rating::with('bracelets')->find($id);

        $bracelets = Bracelet::pluck('name', 'id')->all();

        $media = $rating->getMedia('rating');

        $users = User::pluck('name', 'id')->all();

        return view('admin.ratings.edit', compact('rating', 'bracelets', 'media', 'users'));
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
            'user_id' => request('user_id'),
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
        $rating = Rating::withTrashed()->find($id);

        if ($rating->trashed())
            {
                $rating->forceDelete();
            }
        else
            {
                if ($rating->published == true)

                {
                    $rating->published = false;
                    $rating->save();
                }

                $rating->delete();
            }


        return back();
    }

    public function restore($id)
    {

        $rating = Rating::onlyTrashed()->find($id);

        $rating->restore();

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

}
