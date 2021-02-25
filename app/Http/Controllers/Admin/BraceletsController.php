<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Bracelet;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\BraceletRequest;

class BraceletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $bracelets = Bracelet::with('brands')->paginate(20);
        // dd($bracelets);
        return view('admin.bracelets.index', compact('bracelets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $brands = Brand::pluck('name', 'id')->all();

        return view('admin.bracelets.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BraceletRequest $request)
    {
        
        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        

        $bracelet = Bracelet::create([
                    'name' => request('name'),
                    'slug' => $slug,
                    'title' => request('title'),
                    'description' => request('description'),
                    'brand_id' => request('brand_id'),
                    'year' => request('year'),
                    'country' => request('country'),
                    'compatibility' => request('compatibility'),
                    'assistant_app' => request('assistant_app'),
                    'material' => request('material')
                ]);

        $files = request('files');

        

        $lastbracelet = Bracelet::find($bracelet->id);

        foreach ($files as $file) {
            $lastbracelet->addMedia($file)
                ->toMediaCollection();
        }



        return redirect()->route('bracelets.index');
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
        $bracelet = Bracelet::find($id);

        $braceletbrand = Brand::where('id', $bracelet->brand_id)->select('name')->first();

        $brands = Brand::pluck('name', 'id')->all();

        return view('admin.bracelets.edit', compact('brands', 'bracelet', 'braceletbrand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BraceletRequest $request, $id)
    {
        $bracelet = Bracelet::find($id);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $bracelet->update([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'brand_id' => request('brand_id'),
            'year' => request('year'),
            'country' => request('country'),
            'compatibility' => request('compatibility'),
            'assistant_app' => request('assistant_app'),
            'material' => request('material')
        ]);

        return redirect()->route('bracelets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $brand = Brand::find($id);
        // $brand->delete();

        return redirect()->route('bracelets.index');
    }
}
