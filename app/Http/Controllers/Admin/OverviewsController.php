<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Overview;
use App\Models\Bracelet;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OverviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overviews = Overview::paginate(20);

        return view('admin.overviews.index', compact('overviews'));
    }

    public function publish($id)
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $overview = Overview::find($id);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $overview->update([
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    public function restore($id)
    {

        $overview = Overview::onlyTrashed()->find($id);

        $overview->restore();

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
