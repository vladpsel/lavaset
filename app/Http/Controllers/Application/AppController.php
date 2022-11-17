<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use App\Traits\FeatureTrait;
use Illuminate\Http\Request;

class AppController extends Controller
{
    use FeatureTrait;

    public function home()
    {

        return view('app.home', [
            'categories' => getCategories(),
            'components' => Component::where([
                ['locale', '=', app()->getLocale()],
                ['isVisible', '=', 1]
            ])->orderBy('title', 'asc')->get(),
        ]);
    }
}
