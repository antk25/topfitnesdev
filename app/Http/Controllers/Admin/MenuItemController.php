<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\MenuItem;
use App\Models\GroupMenu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItemRequest;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuitems = MenuItem::with('groupmenu')->paginate(20);

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
    public function store(MenuItemRequest $request)
    {

        $menuitem = MenuItem::create([
            'group_menu_id' => request('group_menu_id'),
            'name' => request('name'),
            'link' => request('link'),
            'position' => request('position'),
            'about' => request('about'),
        ]);

        // Изображение

        if (request('image') != null) {
            $menuitem->addMediaFromRequest('image')
            ->toMediaCollection('menu');
        }

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
    public function update(MenuItemRequest $request, $id)
    {
        $menuitem = MenuItem::find($id);

        $menuitem->update([
            'group_menu_id' => request('group_menu_id'),
            'name' => request('name'),
            'link' => request('link'),
            'position' => request('position'),
            'about' => request('about'),
        ]);

        // Изображение

        if (request('image') != null) {
            $menuitem->addMediaFromRequest('image')
            ->toMediaCollection('menu');
        }

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
