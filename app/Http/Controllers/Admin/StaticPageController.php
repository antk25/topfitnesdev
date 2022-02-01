<?php

namespace App\Http\Controllers\Admin;

use App\Models\StaticPage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StaticPageRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $staticPages = StaticPage::get();

       return view('admin.static-pages.index', compact('staticPages'));
    }

    public function publish($id): RedirectResponse
    {
        $staticPage = StaticPage::find($id);

        if ($staticPage->published)
            {
                $staticPage->published = false;
            }
        else
            {
                $staticPage->published = true;
            }

        $staticPage->save();

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.static-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaticPageRequest $request)
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        $staticPage = StaticPage::create([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'content_raw' => request('content')
        ]);

        /**
        * Обложка
        */

        if (request('cover') != null) {
            $staticPage->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
        }

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $staticPage->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('static-pages');
            }
        }

        if($staticPage->getMedia('static-pages')) {

            $images = $staticPage->getMedia('static-pages');
            $content = $staticPage->content_raw;

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

            $staticPage->content = $content;
            $staticPage->save();
        }

        if ($staticPage) {
            return redirect()
                ->route('pages.edit', $staticPage)
                ->with(['success' => 'Новая страница успешно добавлена. Отредактируйте данные, если нужно']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(StaticPage $staticPage)
    {
        return view('admin.static-pages.edit', compact('staticPage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(StaticPageRequest $request, StaticPage $staticPage)
    {
        if ($request->slug)
        {
            $slug = Str::slug($request->slug, '-');
        }
        else
        {
            $slug = Str::slug($request->name, '-');
        }

        /**
         * Загрузка картинок на сайт и в БД
         */

        $files = request('files');

        if ($files != '') {
            foreach ($files as $file) {
                $staticPage->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection('static-pages');
            }
        }

        $staticPage->update([
            'name' => request('name'),
            'slug' => $slug,
            'title' => request('title'),
            'subtitle' => request('subtitle'),
            'description' => request('description'),
            'content_raw' => request('content'),
        ]);

        if($staticPage->getMedia('static-pages')) {

            $images = $staticPage->getMedia('static-pages');
            $content = $staticPage->content_raw;

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

            $staticPage->content = $content;
            $staticPage->save();
        }

        /**
        * Обложка
        */

        if (request('cover') != null) {
            $staticPage->addMediaFromRequest('cover')
            ->withResponsiveImages()
            ->toMediaCollection('covers');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();

        return back();
    }
}
