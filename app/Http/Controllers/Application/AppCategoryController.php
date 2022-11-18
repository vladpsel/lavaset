<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use Illuminate\Http\Request;

class AppCategoryController extends Controller
{
    public function index(string $a, ?string $b = null)
    {
        if (in_array($a, config('app.available_locales'))) {
            $alias = $b;
        } else {
            $alias = $a;
        }

        $category = Category::where([
            ['locale', '=', app()->getLocale()],
            ['alias', '=', $alias]
        ])->first();

        return view('app.category.index', [
            'category' => $category,
            'products' => Product::where([
                ['locale', '=', app()->getLocale()],
                ['category_id', '=', $category->group],
            ])->get(),
            'components' => Component::where([
                ['locale', '=', app()->getLocale()],
                ['isVisible', '=', 1]
            ])->orderBy('title', 'asc')->get(),
        ]);
    }
}
