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
                    'conclusion_raw' => $request->input('conclusion'),
                    'list_specs' => $request->input('listspecs') ?? [],
                    'type_table' => $request->input('type_table'),
                    'type_grade' => $request->input('type_grade'),
                ]);

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $rating->addMedia($file)
                    ->withResponsiveImages()
                    ->sanitizingFileName(function($fileName) {
                        $fileName = Str::remove('\'', Str::ascii($fileName));
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })
                    ->toMediaCollection('ratings');
            }
        }

        /**
        * Обложка
        */

        if (request('cover') != null) {
            $rating->addMediaFromRequest('cover')
                    ->withResponsiveImages()
                    ->sanitizingFileName(function($fileName) {
                        $fileName = Str::remove('\'', Str::ascii($fileName));
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })
            ->toMediaCollection('covers');
        }

        if($rating->getMedia('ratings')) {

            $images = $rating->getMedia('ratings');
            $content = $rating->conclusion_raw;

            for ($image = 0; $image < count($images); $image++) {
                $content = str_replace("<box_img_half." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block width-50%@md margin-x-auto">
                <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<box_img." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block">
                <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<img." . $image . ">",
                    '
                <figure class="text-component__block">
                    <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>',
                    $content);

            }

            $rating->conclusion = $content;
            $rating->save();
        }


        $allbracelets = collect($request->input('allbracelets'))->filter()->toArray();

        if(count($allbracelets)) {
            $rating->bracelets()->attach($allbracelets);
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

         /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $rating->addMedia($file)
                    ->withResponsiveImages()
                    ->sanitizingFileName(function($fileName) {
                        $fileName = Str::remove('\'', Str::ascii($fileName));
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })
                    ->toMediaCollection('ratings');
            }
        }

       /**
        * Обложка
        */

        if (request('cover') != null) {
            $rating->addMediaFromRequest('cover')
                    ->withResponsiveImages()
                    ->sanitizingFileName(function($fileName) {
                        $fileName = Str::remove('\'', Str::ascii($fileName));
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })
            ->toMediaCollection('covers');
        }

        $result = $rating->update([
            'user_id' => $request->input('user_id'),
            'subtitle' => $request->input('subtitle'),
            'slug' => $slug,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'intro' => $request->input('intro'),
            'conclusion_raw' => $request->input('conclusion'),
            'list_specs' => $request->input('listspecs'),
            'type_table' => $request->input('type_table'),
            'type_grade' => $request->input('type_grade'),
        ]);



        if($rating->getMedia('ratings')) {

            $images = $rating->getMedia('ratings');
            $content = $rating->conclusion_raw;

            for ($image = 0; $image < count($images); $image++) {
                $content = str_replace("<box_img_half." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block width-50%@md margin-x-auto">
                <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<box_img." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block">
                <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<img." . $image . ">",
                    '
                <figure class="text-component__block">
                    <img src="' . $images[$image]->getUrl('lquip') . '"
                    class="lazy block width-100%"
                    data-srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                    <noscript><img src="' . $images[$image]->getUrl() . '" alt="'. $images[$image]->name .'"></noscript>
                </figure>',
                    $content);

            }

            $rating->conclusion = $content;
            $rating->save();
        }


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
