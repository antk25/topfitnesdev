<?php


namespace App\Http\ViewComposers;

use App\Models\Bracelet;
use App\Models\Comparison;
use App\Models\Manual;
use App\Models\Overview;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\View\View;

class LinkTreeMapComposer
{
    public function compose(View $view)
    {
        $posts = Post::get();
        $comparisons = Comparison::get();
        $bracelets = Bracelet::get();
        $manuals = Manual::get();
        $overviews = Overview::get();
        $ratings = Rating::get();

        return $view->with([
            'posts' => $posts,
            'bracelets' => $bracelets,
            'comparisons' => $comparisons,
            'manuals' => $manuals,
            'overviews' => $overviews,
            'ratings' => $ratings
        ]);

    }

}
