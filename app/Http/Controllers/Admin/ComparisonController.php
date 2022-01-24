<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComparisonRequest;
use App\Models\Comparison;
use App\Models\Bracelet;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComparisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $comparisons = Comparison::paginate(20);

        return view('admin.comparisons.index', compact('comparisons'));
    }

    public function publish($id): RedirectResponse
    {
        $comparison = Comparison::find($id);

        if ($comparison->published)
        {
            $comparison->published = false;
        }
        else
        {
            $comparison->published = true;
        }

        $comparison->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->all();

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.comparisons.create', compact('users', 'bracelets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ComparisonRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(ComparisonRequest $request): RedirectResponse
    {

        if ($request->input('slug'))
        {
            $slug = Str::slug($request->input('slug'), '-');
        }
        else
        {
            $slug = Str::slug($request->input('name'), '-');
        }

        $listspecs = collect($request->input('listspecs'));

        $listspecs = $listspecs->whereNotNull('specs')->toArray();

        $comparison = Comparison::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'content_raw' => request('content'),
            'list_specs' => $listspecs ?? [],
            'type_table' => $request->input('type_table'),
        ]);

        $comparison->bracelets()->attach($request->input('allbracelets', []));

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $comparison->addMedia($file)
                    ->toMediaCollection('comparisons');
            }
        }

        //Обложка статьи

        $cover = request('cover');

        if (isset($cover)) {
            $comparison->addMediaFromRequest('cover')->toMediaCollection('covers');
        }


        if ($comparison) {
            return redirect()
                 ->route('comparisons.edit', $comparison->id)
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
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $comparison = Comparison::with('bracelets')->find($id);

        $users = User::pluck('name', 'id')->all();

        $media = $comparison->getMedia('comparisons');

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.comparisons.edit', compact('comparison', 'media', 'users', 'bracelets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ComparisonRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(ComparisonRequest $request, $id): RedirectResponse
    {
        $listspecs = collect($request->input('listspecs'));

        $listspecs = $listspecs->whereNotNull('specs')->toArray();

        $comparison = Comparison::find($id);

        $slug = $request->input('slug');
        $slug = Str::slug($slug, '-');

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $comparison->addMedia($file)
                    ->toMediaCollection('comparisons');
            }
        }

        $comparison->update([
            'user_id' => $request->input('user_id'),
            'name' => $request->input('name'),
            'slug' => $slug,
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'description' => $request->input('description'),
            'content_raw' => $request->input('content'),
            'list_specs' => $listspecs ?? [],
            'type_table' => $request->input('type_table'),
        ]);

        $comparison->bracelets()->sync($request->input('allbracelets', []));

        if($comparison->getMedia('comparisons')) {

            $images = $comparison->getMedia('comparisons');
            $content = $comparison->content_raw;

            for ($image = 0; $image < count($images); $image++) {
                $content = str_replace("<box_img_half." . $image . ">",
                    '<div class="box">
               <a href="' . $images[$image]->getUrl() . '">
              <figure class="text-component__block width-50%@md margin-x-auto">
                <img src="' . $images[$image]->getUrl() . '"
                 srcset="' . $images[$image]->getUrl('320') . ' 320w,
                ' . $images[$image]->getUrl('640') . ' 640w,
                ' . $images[$image]->getUrl('960') . ' 960w,
                ' . $images[$image]->getUrl('1280') . ' 1280w,
                " alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<box_img." . $image . ">",
                    '<div class="box">
               <a href="' . $images[$image]->getUrl() . '">
              <figure class="text-component__block">
                <img src="' . $images[$image]->getUrl() . '"
                 srcset="' . $images[$image]->getUrl('320') . ' 320w,
                ' . $images[$image]->getUrl('640') . ' 640w,
                ' . $images[$image]->getUrl('960') . ' 960w,
                ' . $images[$image]->getUrl('1280') . ' 1280w,
                " alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<img." . $image . ">",
                    '
                    <figure class="text-component__block">
                    <img src="' . $images[$image]->getUrl() . '"
                 srcset="' . $images[$image]->getUrl('320') . ' 320w,
                ' . $images[$image]->getUrl('640') . ' 640w,
                ' . $images[$image]->getUrl('960') . ' 960w,
                ' . $images[$image]->getUrl('1280') . ' 1280w,
                " alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>',
                    $content);

            }

            $comparison->content = $content;
            $comparison->save();
        }

        //Обложка статьи

        $cover = request('cover');

        if (isset($cover)) {
            $comparison->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $comparison = Comparison::withTrashed()->find($id);

        if ($comparison->trashed())
            {
                $comparison->forceDelete();
            }
        else
            {
                if ($comparison->published == true)

                {
                    $comparison->published = false;
                    $comparison->save();
                }

                $comparison->delete();
            }

        return back();
    }

    public function restore($id): RedirectResponse
    {

        $comparison = Comparison::onlyTrashed()->find($id);

        $comparison->restore();

        return back();

    }

    public function imgdelete(Request $request): RedirectResponse
    {

        $imgid = $request->imgid;

        $mediaItems = Media::find($imgid);

        $mediaItems->delete();

        return back();

    }

    public function imgupdate(Request $request): RedirectResponse
    {
        $id = $request->imgid;
        $image = Media::find($id);

        $image->update([
            'name' => request('nameimg')
        ]);


        return back();

    }
}
