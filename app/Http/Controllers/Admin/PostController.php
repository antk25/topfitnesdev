<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Ternary;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $posts = Post::withTrashed()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function publish($id): RedirectResponse
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
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->all();
        return view('admin.posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(PostRequest $request): RedirectResponse
    {
        if ($request->input('slug'))
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $post = Post::create([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'sources' => request('sources'),
            'content_raw' => request('content'),
        ]);

        if($post->getMedia('posts')) {

            $images = $post->getMedia('posts');
            $content = $post->content_raw;

            for ($image = 0; $image < count($images); $image++) {
                $content = str_replace("<box_img." . $image . ">",
                    '<figure class="box">
               <a href="' . $images[$image]->getUrl() . '">
                <img src="' . $images[$image]->getUrl() . '"
                 srcset="' . $images[$image]->getUrl('320') . ' 320w,
                ' . $images[$image]->getUrl('640') . ' 640w,
                ' . $images[$image]->getUrl('960') . ' 960w,
                ' . $images[$image]->getUrl('1280') . ' 1280w,
                " alt="'. $images[$image]->name .'">
               </a>
               </figure>',
                    $content);
                $content = str_replace("<img." . $image . ">",
                    '<img src="' . $images[$image]->getUrl() . '"
                 srcset="' . $images[$image]->getUrl('320') . ' 320w,
                ' . $images[$image]->getUrl('640') . ' 640w,
                ' . $images[$image]->getUrl('960') . ' 960w,
                ' . $images[$image]->getUrl('1280') . ' 1280w,
                " alt="'. $images[$image]->name .'">',
                    $content);

            }

            $post->content = $content;
            $post->save();
        }


        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $post->addMedia($file)
                    ->toMediaCollection('posts');
            }
        }

       /**
        * Обложка
        */

        if (request('cover') != null) {
            $post->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
        }

        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);

        $users = User::pluck('name', 'id')->all();

        return view('admin.posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param int $id
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(PostRequest $request, $id): RedirectResponse
    {
        $post = Post::find($id);

        $slug = $request->input('slug');
        $slug = Str::slug($slug, '-');

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $post->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('posts');
            }
        }

        $post->update([
            'user_id' => request('user_id'),
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'sources' => request('sources'),
            'content_raw' => request('content')
        ]);

        if($post->getMedia('posts')) {

            $images = $post->getMedia('posts');
            $content = $post->content_raw;

            for ($image = 0; $image < count($images); $image++) {
                $content = str_replace("<box_img_half." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block width-50%@md margin-x-auto">
                <img src="' . $images[$image]->getUrl() . '"
                    onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+\'vw\';});"
                    sizes="1px"
                    srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<box_img." . $image . ">",
                    '<div class="box">
                <a href="' . $images[$image]->getUrl() . '">
                <figure class="text-component__block">
                <img src="' . $images[$image]->getUrl() . '"
                    onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+\'vw\';});"
                    sizes="1px"
                    srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>
               </a>
               </div>',
                    $content);
                $content = str_replace("<img." . $image . ">",
                    '
                <figure class="text-component__block">
                    <img src="' . $images[$image]->getUrl() . '"
                    onload="window.requestAnimationFrame(function(){if(!(size=getBoundingClientRect().width))return;onload=null;sizes=Math.ceil(size/window.innerWidth*100)+\'vw\';});"
                    sizes="1px"
                    srcset="' . $images[$image]->getSrcset() . '"
                    alt="'. $images[$image]->name .'" title="'. $images[$image]->name .'">
                </figure>',
                    $content);

            }

            $post->content = $content;
            $post->save();
        }

        //Обложка статьи

        if (request('cover') != null) {
            $post->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
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

    public function restore($id): RedirectResponse
    {

        $post = Post::onlyTrashed()->find($id);

        $post->restore();

        return back();

    }

}
