<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Traits\FeatureTrait;
use Illuminate\Http\Request;

class AppController extends Controller
{
    use FeatureTrait;

    public function home()
    {
        return view('app.home');
    }
}
