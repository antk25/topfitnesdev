<?php

namespace App\Http\Controllers\Comparison;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComparisonRequest;
use App\Models\Comparison;
use App\Models\Bracelet;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminComparisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comparisons = Comparison::paginate(20);

        return view('admin.comparisons.index', compact('comparisons'));
    }

    public function publish($id)
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComparisonRequest $request)
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $comparison = Comparison::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
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
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComparisonRequest $request, $id)
    {
        $comparison = Comparison::find($id);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $comparison->update([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $comparison->bracelets()->sync($request->input('allbracelets', []));

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $comparison->addMedia($file)
                    ->toMediaCollection('comparisons');
            }
        }

        return redirect()->route('comparisons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

    public function restore($id)
    {

        $comparison = Comparison::onlyTrashed()->find($id);

        $comparison->restore();

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
