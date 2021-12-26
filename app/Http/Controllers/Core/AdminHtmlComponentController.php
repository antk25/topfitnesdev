<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HtmcomponentRequest;
use App\Models\HtmlComponent;
use Illuminate\Http\Request;

class AdminHtmlComponentController extends Controller
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
    public function store(HtmcomponentRequest $request)
    {
       $htmlcomponent = HtmlComponent::create([
            'name' => $request->name,
            'code' => $request->code,
            'about' => $request->about,
       ]);

       $file = request('file');

       if ($file != '') {

        $htmlcomponent->addMedia($file)->toMediaCollection('htmlcomponents');

       }

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
     * Display the specified resource.
     *
     * @param  \App\Models\HtmlComponent  $htmlComponent
     * @return \Illuminate\Http\Response
     */
    public function show(HtmlComponent $htmlComponent)
    {
        //
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
    public function update(HtmcomponentRequest $request, HtmlComponent $htmlcomponent)
    {
        $htmlcomponent->update([
            'name' => $request->name,
            'code' => $request->code,
            'about' => $request->about,
       ]);


       $file = request('file');

       if ($file != '') {

        $htmlcomponent->addMedia($file)->toMediaCollection('htmlcomponents');

       }

       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HtmlComponent  $htmlComponent
     * @return \Illuminate\Http\Response
     */
    public function destroy(HtmlComponent $htmlComponent)
    {
        //
    }
}
