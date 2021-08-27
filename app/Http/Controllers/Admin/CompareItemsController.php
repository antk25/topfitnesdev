<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Comparison;
use App\Models\CompareItem;
use DB;

class CompareItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compareitems = CompareItem::paginate(20);

        return view('admin.compareitems.index', compact('compareitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $bracelet_compare = DB::table('bracelet_comparison')->where('comparison_id','=',$request->comparison)->pluck('bracelet_id')->toArray(); 

        $bracelets = Bracelet::whereIn('id', $bracelet_compare)->pluck('name', 'id');

        $comparisons = Comparison::find($request->comparison);

        return view('admin.compareitems.create', compact('bracelets', 'comparisons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $compareitem = CompareItem::create([
            'bracelet_id' => request('bracelet_id'),
            'comparison_id' => request('comparison_id'),
            'name' => request('name'),
            'content' => request('content')
        ]);

        $files = request('files');

        $nameimg = request('nameimg');
        
        if ($files != '') {
            $lastpost = CompareItem::find($compareitem->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('compareitems');
            }
        }

        return redirect()->route('compareitems.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $compareitem = CompareItem::find($id);

        $bracelets = Bracelet::pluck('name', 'id')->all();

        $media = $compareitem->getMedia('images');
        
        return view('admin.compareitems.edit', compact('compareitem', 'media', 'bracelets'));
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
        $compareitem = CompareItem::find($id);

        $compareitem->update([
            'bracelet_id' => request('bracelet_id'),
            'comparison_id' => request('comparison_id'),
            'name' => request('name'),
            'content' => request('content')
        ]);

        $files = request('files');
        $nameimg = request('nameimg');
        
        if ($files != '' && $nameimg[0] != '') {
            $lastpost = CompareItem::find($compareitem->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('compareitems');
            }
        }
        elseif ($files != '') {
            $lastpost = CompareItem::find($compareitem->id);
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->toMediaCollection('compareitems');
            }
        }

        return redirect()->route('compareitems.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CompareItem::destroy($id);
        
        return redirect()->route('compareitems.index');
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
