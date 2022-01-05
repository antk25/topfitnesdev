<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Grade;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Spec;
use Illuminate\Http\Request;

class ComponentsPageController extends Controller
{
   protected $grades;
   protected $sellers;
   protected $reviews;
   protected $comments;
   protected $brands;
   protected $specs;

   public function index()
   {
       $grades = Grade::pluck('id')->all();
       $sellers = Seller::pluck('id')->all();
       $reviews = Review::pluck('id')->all();
       $comments = Comment::pluck('id')->all();
       $brands = Brand::pluck('id')->all();
       $specs = Spec::pluck('id')->all();

       return view('admin.components', compact('grades', 'sellers', 'reviews', 'comments', 'brands', 'specs'));
   }
}
