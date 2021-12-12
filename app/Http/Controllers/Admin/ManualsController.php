<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bracelet;
use App\Models\Manual;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class ManualsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manuals = Manual::paginate(20);

        return view('admin.manuals.index', compact('manuals'));
    }

    public function publish($id)
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $manual->bracelets()->attach($request->input('allbracelets', []));

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $manual->addMedia($file)
                    ->toMediaCollection('manuals');
            }
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
        $manual = Manual::with('bracelets')->find($id);

        $users = User::pluck('name', 'id')->all();

        $media = $manual->getMedia('manuals');

        $bracelets = Bracelet::pluck('name', 'id')->all();

        return view('admin.manuals.edit', compact('manual', 'media', 'users', 'bracelets'));
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
        $manual = Manual::find($id);

        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $manual->update([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $manual->bracelets()->sync($request->input('allbracelets', []));

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $manual->addMedia($file)
                    ->toMediaCollection('manuals');
            }
        }

        return redirect()->route('manuals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

    public function restore($id)
    {

        $manual = Manual::onlyTrashed()->find($id);

        $manual->restore();

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
