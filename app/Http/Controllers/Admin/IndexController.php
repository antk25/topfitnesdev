<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;


class IndexController extends Controller
{
    public function __invoke() {

        return view('admin.index');
    }

}
