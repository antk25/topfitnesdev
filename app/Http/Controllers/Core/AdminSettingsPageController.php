<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\HtmlComponent;
use Illuminate\Http\Request;

class AdminSettingsPageController extends Controller
{
   protected $htmlcomponents;

   public function index()
   {
       $htmlcomponents = HtmlComponent::pluck('id')->all();

       return view('admin.settings', compact('htmlcomponents'));
   }
}
