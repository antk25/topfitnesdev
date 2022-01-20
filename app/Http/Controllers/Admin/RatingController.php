<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Bracelet;
use App\Http\Requests\Admin\RatingRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        $ratings = Rating::paginate(20);

        return view('admin.ratings.index', compact('ratings'));
    }


    public function publish($id): RedirectResponse
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
     * @return Application|Factory|View
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
     * @param RatingRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(RatingRequest $request): RedirectResponse
    {

        if ($request->input('slug'))
        {
            $slug = Str::slug($request->input('slug'), '-');
        }
        else
        {
            $slug = Str::slug($request->input('name'), '-');
        }

        $rating = Rating::create([
                    'user_id' => $request->input('user_id'),
                    'subtitle' => $request->input('subtitle'),
                    'name' => $request->input('name'),
                    'slug' => $slug,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'intro' => $request->input('intro'),
                    'conclusion' => $request->input('conclusion'),
                    'list_specs' => $request->input('listspecs') ?? [],
                    'type_table' => $request->input('type_table'),
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

        $allbracelets = collect($request->input('allbracelets'))->filter()->toArray();

        if(count($allbracelets)) {
            $rating->bracelets()->attach($allbracelets);
        }

        //Обложка статьи

        $cover = request('cover');

        if (isset($cover)) {
            $rating->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        if ($rating) {
            return redirect()
                ->route('ratings.edit', $rating->id)
                ->with(['success' => 'Новая статья успешно добавлена. Отредактируйте данные, если нужно']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
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
     * @param RatingRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(RatingRequest $request, $id): RedirectResponse
    {
        $rating = Rating::find($id);

        // $bracelets = $request->bracelets;

        // $position_rating = $request->position_rating;

        // $text_rating = $request->text_rating;

        // $extra = array_map(function($p, $r){
            // return ['position' => $p, 'text_rating' => $r];
        // }, $position_rating, $text_rating);

        // $data = array_combine($bracelets, $extra);

//        $keys = array_column($listspecs, 'specs');
//        $values = array_column($listspecs, 'value');
        $slug = $request->input('slug');
        $slug = Str::slug($slug, '-');

//        $listspecs = array_combine($request->input('listspecskey'), $request->input('listspecsvalue'));

        $result = $rating->update([
            'user_id' => $request->input('user_id'),
            'subtitle' => $request->input('subtitle'),
            'slug' => $slug,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'intro' => $request->input('intro'),
            'conclusion' => $request->input('conclusion'),
            'list_specs' => $request->input('listspecs'),
            'type_table' => $request->input('type_table'),
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

        //Обложка статьи

        $cover = request('cover');

        if (isset($cover)) {
            $rating->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        if ($result) {
          return redirect()
                 ->route('ratings.edit', $rating->id)
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
     * @return RedirectResponse
     */

    public function destroy($id): RedirectResponse
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

    public function restore($id): RedirectResponse
    {

        $rating = Rating::onlyTrashed()->find($id);

        $rating->restore();

        return back();

    }

    public function imgdelete(Request $request): RedirectResponse
    {

        $imgid = $request->input('imgid');

        $mediaItems = Media::find($imgid);

        $mediaItems->delete();

        return back();

    }

    public function imgupdate(Request $request): RedirectResponse
    {
        $id = $request->input('imgid');
        $image = Media::find($id);

        $image->update([
            'name' => request('nameimg')
        ]);

        return back();

    }

}
