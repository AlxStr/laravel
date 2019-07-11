<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class HomeController
 *
 * @package App\Http\Admin
 */
class HomeController extends Controller
{


    public function index()
    {
        return view('admin.home');
    }
}
