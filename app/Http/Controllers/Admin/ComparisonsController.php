<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comparison;
use App\Models\Bracelet;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComparisonsController extends Controller
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
    public function store(Request $request)
    {
        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        $comparison = Comparison::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $comparison->bracelets()->attach($request->input('bracelets', []));

        $files = request('files');

        $nameimg = request('nameimg');
        
        if ($files != '') {
            $lastpost = Comparison::find($comparison->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('comparisons');
            }
        }

        return redirect()->route('comparisons.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comparison = Comparison::find($id);

        $users = User::pluck('name', 'id')->all();
        
        $bracelets = Bracelet::pluck('name', 'id')->all();

        $media = $comparison->getMedia('images');
        
        return view('admin.comparisons.edit', compact('comparison', 'media', 'users', 'bracelets'));
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

        $comparison->bracelets()->sync($request->input('bracelets', []));

        $files = request('files');
        $nameimg = request('nameimg');
        
        if ($files != '' && $nameimg[0] != '') {
            $lastpost = Comparison::find($comparison->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('comparisons');
            }
        }
        elseif ($files != '') {
            $lastpost = Comparison::find($comparison->id);
            foreach ($files as $file) {
                $lastpost->addMedia($file)
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
        Comparison::destroy($id);
        
        return redirect()->route('comparisons.index');
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
