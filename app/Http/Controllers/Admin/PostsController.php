<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('email', 'id')->all();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = $request->slug;

        $slug = Str::slug($slug, '-');

        $post = Post::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $files = request('files');

        $nameimg = request('nameimg');
        
        if ($files != '') {
            $lastpost = Post::find($post->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $users = User::pluck('email', 'id')->all();

        $media = $post->getMedia('images');
        
        return view('admin.posts.edit', compact('post', 'media', 'users'));
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
        $post = Post::find($id);

        $slug = $request->slug;
        $slug = Str::slug($slug, '-');

        $post->update([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('title'),
            'description' => request('description'),
            'content' => request('content')
        ]);

        $files = request('files');
        $nameimg = request('nameimg');
        
        if ($files != '' && $nameimg[0] != '') {
            $lastpost = Post::find($post->id);
            $i = 0;
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->usingName($nameimg[$i++])
                    ->toMediaCollection('images');
            }
        }
        elseif ($files != '') {
            $lastpost = Post::find($post->id);
            foreach ($files as $file) {
                $lastpost->addMedia($file)
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        
        return redirect()->route('posts.index');
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
