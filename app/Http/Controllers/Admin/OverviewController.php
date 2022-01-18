<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OverviewRequest;
use App\Models\Overview;
use App\Models\Bracelet;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $overviews = Overview::paginate(20);

        return view('admin.overviews.index', compact('overviews'));
    }

    public function publish($id): RedirectResponse
    {
        $overview = Overview::find($id);

        if ($overview->published)
        {
            $overview->published = false;
        }
        else
        {
            $overview->published = true;
        }

        $overview->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return ApplicationAlias|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->all();

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.overviews.create', compact('users', 'bracelets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OverviewRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(OverviewRequest $request)
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $overview = Overview::create([
            'user_id' => request('user_id'),
            'bracelet_id' => request('bracelet_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $overview->addMedia($file)
                    ->toMediaCollection('overviews');
            }
        }

        return redirect()->route('overviews.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return ApplicationAlias|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $overview = Overview::find($id);

        $users = User::pluck('name', 'id')->all();

        $bracelets = Bracelet::pluck('name', 'id')->all();

        $media = $overview->getMedia('overviews');

        return view('admin.overviews.edit', compact('overview', 'media', 'users', 'bracelets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OverviewRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(OverviewRequest $request, int $id): RedirectResponse
    {
        $overview = Overview::find($id);

        $slug = $request->input('slug');
        $slug = Str::slug($slug, '-');

        $overview->update([
            'user_id' => request('user_id'),
            'bracelet_id' => request('bracelet_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content'),
        ]);

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $overview->addMedia($file)
                    ->toMediaCollection('overviews');
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $overview = Overview::withTrashed()->find($id);

        if ($overview->trashed())
            {
                $overview->forceDelete();
            }
        else
            {
                if ($overview->published == true)

                {
                    $overview->published = false;
                    $overview->save();
                }

                $overview->delete();
            }


        return back();
    }

    public function restore($id): RedirectResponse
    {

        $overview = Overview::onlyTrashed()->find($id);

        $overview->restore();

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
