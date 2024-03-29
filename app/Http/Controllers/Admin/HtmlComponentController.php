<?php

namespace App\Http\Controllers\Admin;

use App\Exports\HtmlComponentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HtmlComponentRequest;
use App\Imports\HtmlComponentImport;
use App\Models\HtmlComponent;
use Illuminate\Http\Request;

class HtmlComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $htmlcomponents = HtmlComponent::paginate(20);

        return view('admin.htmlcomponents.index', compact('htmlcomponents'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.htmlcomponents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HtmlComponentRequest $request)
    {
       $htmlcomponent = HtmlComponent::create([
            'name' => $request->name,
            'code' => $request->code,
            'link' => $request->link,
            'about' => $request->about,
       ]);

       if ($htmlcomponent) {
          return redirect()
                 ->route('htmlcomponents.edit', $htmlcomponent->id)
                 ->with(['success' => 'Внесенные изменения были сохранены']);
           } else {
            return back()
                    ->withErrors(['msg' => 'Ошибка сохранения'])
                    ->withInput();
           }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HtmlComponent  $htmlComponent
     * @return \Illuminate\Http\Response
     */
    public function edit(HtmlComponent $htmlcomponent)
    {
        return view('admin.htmlcomponents.edit', compact('htmlcomponent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HtmlComponent  $htmlComponent
     * @return \Illuminate\Http\Response
     */
    public function update(HtmlComponentRequest $request, $id)
    {
        $htmlcomponent = HtmlComponent::find($id);

        $htmlcomponent->update([
            'name' => $request->input('name'),
            'link' => $request->input('link'),
            'code' => $request->input('code'),
            'about' => $request->input('about'),
       ]);

       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HtmlComponent  $htmlComponent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HtmlComponent::destroy($id);

        return back();
    }

    public function import(Request $request)
    {
        $file = $request->file('importFile');

        $import = new HtmlComponentImport();

        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->with('success', 'Завершено!');
    }

    public function export()
    {
        return new HtmlComponentExport;
    }
}
