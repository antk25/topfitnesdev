<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bracelet;
use App\Models\Comparison;
use App\Models\Manual;
use App\Models\Overview;
use App\Models\Post;
use App\Models\Rating;
use Illuminate\Http\Request;

class TypePagesController extends Controller
{
   protected $bracelets;
   protected $ratings;
   protected $posts;
   protected $overviews;
   protected $comparisons;
   protected $manuals;

   public function index()
   {
       $bracelets = Bracelet::pluck('id')->all();
       $ratings = Rating::pluck('id')->all();
       $posts = Post::pluck('id')->all();
       $overviews = Overview::pluck('id')->all();
       $comparisons = Comparison::pluck('id')->all();
       $manuals = Manual::pluck('id')->all();

       return view('admin.pages', compact('bracelets', 'ratings', 'posts', 'overviews', 'comparisons', 'manuals'));
   }
}
