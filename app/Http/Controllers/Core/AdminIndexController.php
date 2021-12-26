<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Brand;


class AdminIndexController extends Controller
{
    public function __invoke() {

        return view('admin.index');
    }

}
