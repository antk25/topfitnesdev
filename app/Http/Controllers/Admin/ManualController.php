<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManualRequest;
use App\Models\Bracelet;
use App\Models\Manual;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $manuals = Manual::paginate(20);

        return view('admin.manuals.index', compact('manuals'));
    }

    public function publish($id): RedirectResponse
    {
        $manual = Manual::find($id);

        if ($manual->published)
        {
            $manual->published = false;
        }
        else
        {
            $manual->published = true;
        }

        $manual->save();

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

        return view('admin.manuals.create', compact('users', 'bracelets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManualRequest $request
     * @return RedirectResponse
     */
    public function store(ManualRequest $request): RedirectResponse
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $manual = Manual::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'content_raw' => request('content')
        ]);

        $allbracelets = collect($request->input('allbracelets'))->filter()->toArray();

        if(count($allbracelets)) {
            $manual->bracelets()->attach($allbracelets);
        }

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $manual->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('manuals');
            }
        }

        if (request('cover') != null) {
            $manual->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
        }

        if ($manual) {
            return redirect()
                 ->route('manuals.edit', $manual->id)
                 ->with(['success' => 'Новая статья успешно добавлена. Отредактируйте данные, если нужно']);
           } else {
            return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
           }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $manual = Manual::with('bracelets')->find($id);

        $users = User::pluck('name', 'id')->all();

        $media = $manual->getMedia('manuals');

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.manuals.edit', compact('manual', 'media', 'users', 'bracelets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManualRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ManualRequest $request, $id): RedirectResponse
    {
        $manual = Manual::find($id);

        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $manual->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('manuals');
            }
        }

        $manual->update([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'content_raw' => request('content')
        ]);

        $allbracelets = $request->input('allbracelets', []);

        if(!is_null($allbracelets)) {
            $manual->bracelets()->sync($allbracelets);
        }
        else {
            $bracelets = $manual->bracelets->pluck('id')->all();
            $manual->bracelets()->detach($bracelets);
        }

        if($manual->getMedia('manuals')) {

            $images = $manual->getMedia('manuals');
            $content = $manual->content_raw;

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

            $manual->content = $content;
            $manual->save();
        }

        if (request('cover') != null) {
            $manual->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
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
        $manual = Manual::withTrashed()->find($id);

        if ($manual->trashed())
            {
                $manual->forceDelete();
            }
        else
            {
                if ($manual->published == true)

                {
                    $manual->published = false;
                    $manual->save();
                }

                $manual->delete();
            }


        return back();
    }

    public function restore($id): RedirectResponse
    {

        $manual = Manual::onlyTrashed()->find($id);

        $manual->restore();

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
