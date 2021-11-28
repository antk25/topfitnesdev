<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Http\Requests\Admin\BrandRequest;
use App\Imports\BrandsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(20);

        $lastfile = head(Storage::files('import/brands'));

        return view('admin.brands.index', compact('brands', 'lastfile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        Brand::create([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'about' => request('about')
        ]);


        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::find($id);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $brand->update([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'description' => request('description'),
            'about' => request('about')
        ]);

        return redirect()->route('brands.index');
    }

    public function import(Request $request)
    {
        $file = $request->file('importFile')->store('import/brands');

        $import = new BrandsImport();

        $import->import($file);


        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->with('success', 'Завершено!');
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
        Brand::destroy($id);

        return redirect()->route('brands.index');
    }
}
