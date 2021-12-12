<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Ternary;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::withTrashed()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function publish($id)
    {
        $post = Post::find($id);

        if ($post->published)
        {
            $post->published = false;
        }
        else
        {
            $post->published = true;
        }

        $post->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->all();
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

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $post->addMedia($file)
                    ->toMediaCollection('posts');
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

        $users = User::pluck('name', 'id')->all();

        $media = $post->getMedia('posts');

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

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            $i = 0;
            foreach ($files as $file) {
                $post->addMedia($file)
                    ->toMediaCollection('posts');
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
        $post = Post::withTrashed()->find($id);

        if ($post->trashed())
            {
                $post->forceDelete();
            }
        else
            {
                if ($post->published == true)

                {
                    $post->published = false;
                    $post->save();
                }

                $post->delete();
            }


        return back();
    }

    public function restore($id)
    {

        $post = Post::onlyTrashed()->find($id);

        $post->restore();

        return back();

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
