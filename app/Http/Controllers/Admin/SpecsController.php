<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SpecsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Spec;
use Illuminate\Support\Facades\Storage;

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

        $lastfile = head(Storage::files('import/specs'));

        return view('admin.specs.index', compact('specs', 'lastfile'));
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
        // $slug = $request->slug;

        // $slug = Str::slug($slug, '-');

        $allvalues = $request->allvalues;

        $values = array_column($allvalues, 'value');

        $slugs = array_map(array($this, 'slugAr') , $values);

        $values = array_combine($values, $slugs);

        Spec::create([
            'device' => request('device'),
            'name' => request('name'),
            'value' => $values,
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

        // $slug = $request->slug;

        // $slug = Str::slug($slug, '-');


        $allvalues = $request->allvalues;

        $values = array_column($allvalues, 'value');
        $slugs = array_column($allvalues, 'slug');

        $values = array_combine($values, $slugs);

        $spec->update([
            'device' => request('device'),
            'name' => request('name'),
            'value' => $values,
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

        return redirect()->route('specs.index');
    }

    private function slugAr($values)
    {
       return (Str::slug($values, '-'));
    }


    public function import(Request $request)
    {

       $request->validate([
        'importFile' => 'required',
       ]);

       $file = $request->file('importFile')->store('import/specs');

       $import = new SpecsImport();

       $import->import($file);


       if ($import->failures()->isNotEmpty())
       {
           return back()->withFailures($import->failures());
       }


       return back()->with('success', 'Завершено!');
    }


}
