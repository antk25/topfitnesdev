<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Http\Requests\Admin\SellerRequest;
use Illuminate\Support\Str;


class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::paginate(20);
        return view('admin.sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $request)
    {

        Seller::create([
            'name' => request('name'),
            'marketplace' => request('marketplace'),
            'about' => request('about')
        ]);

        return redirect()->route('sellers.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::find($id);

        return view('admin.sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerRequest $request, $id)
    {
        $seller = Seller::find($id);

        $seller->update([
            'name' => request('name'),
            'slug' => request('slug'),
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'rating' => request('rating'),
            'about' => request('about')
        ]);

        return redirect()->route('sellers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Seller::destroy($id);

        return redirect()->route('sellers.index');
    }
}
