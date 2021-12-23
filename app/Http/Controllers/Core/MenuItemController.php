<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\MenuItem;
use App\Models\GroupMenu;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuitems = MenuItem::paginate(20);

        return view('admin.menuitems.index', compact('menuitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Модифицировать через livewire: если выбираем посты, то подгружаются посты, если рейтинги, то рейтинг и т.д.
    public function create()
    {
        $posts = Post::pluck('slug', 'id')->all();

        $groupmenus = GroupMenu::pluck('name', 'id')->all();

        return view('admin.menuitems.create', compact('posts', 'groupmenus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        MenuItem::create([
            'group_menu_id' => request('group_menu_id'),
            'name' => request('name'),
            'link' => request('link'),
            'position' => request('position'),
        ]);

        return redirect()->route('menuitems.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menuitem = MenuItem::find($id);

        $posts = Post::pluck('slug', 'id')->all();

        $groupmenus = GroupMenu::pluck('name', 'id')->all();

        $groupmenusid = GroupMenu::where('id', $menuitem->group_menu_id)->first();

        $menupostslug = Post::where('id', $menuitem->post_id)->select('id')->first();

        return view('admin.menuitems.edit', compact('menuitem', 'posts', 'menupostslug', 'groupmenus', 'groupmenusid'));
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
        $menuitem = MenuItem::find($id);

        $menuitem->update([
            'group_menu_id' => request('group_menu_id'),
            'name' => request('name'),
            'link' => request('link'),
            'position' => request('position'),
        ]);

        return redirect()->route('menuitems.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MenuItem::destroy($id);

        return redirect()->route('menuitems.index');
    }

}
