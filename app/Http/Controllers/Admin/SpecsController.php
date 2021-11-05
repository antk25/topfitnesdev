<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Spec;

class SpecsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specs = Spec::paginate(20);
        return view('admin.specs.index', compact('specs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specs = Spec::get();

        return view('admin.specs.create', compact('specs'));
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

        Spec::create([
            'device' => request('device'),
            'name' => request('name'),
            'value' => request('value'),
            'slug' => $slug,
        ]);

        return redirect()->route('specs.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $spec = Spec::find($id);

        return view('admin.specs.edit', compact('spec'));
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
        $spec = Spec::find($id);

        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        $spec->update([
            'device' => request('device'),
            'name' => request('name'),
            'value' => request('value'),
            'slug' => $slug,
        ]);

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Spec::destroy($id);

        return redirect()->route('admin.specs.index');
    }
}
