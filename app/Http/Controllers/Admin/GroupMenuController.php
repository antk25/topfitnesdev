<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuItem;
use App\Models\GroupMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GroupMenuRequest;

class GroupMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupmenus = GroupMenu::paginate(20);

        return view('admin.groupmenus.index', compact('groupmenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.groupmenus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupMenuRequest $request)
    {

        GroupMenu::create([
            'name' => request('name'),
            'place' => request('place'),
            'about' => request('about'),
        ]);

        return redirect()->route('groupmenus.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $groupmenu = GroupMenu::find($id);

        return view('admin.groupmenus.edit', compact('groupmenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupMenuRequest $request, $id)
    {
        $groupmenu = GroupMenu::find($id);

        $groupmenu->update([
            'name' => request('name'),
            'place' => request('place'),
            'about' => request('about'),
        ]);

        return redirect()->route('groupmenus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GroupMenu::destroy($id);

        return redirect()->route('groupmenus.index');
    }
}
