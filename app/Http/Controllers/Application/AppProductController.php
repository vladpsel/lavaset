<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use Illuminate\Http\Request;

class AppProductController extends Controller
{
    public function index(string $a, ?string $b = null)
    {
        if (in_array($a, config('app.available_locales'))) {
            $alias = $b;
        } else {
            $alias = $a;
        }

        $product = Product::where([
            ['locale', '=', app()->getLocale()],
            ['alias', '=', $alias]
        ])->first();

        if (!$product || empty($product)) {
            abort(404);
        }

        $category = Category::where([
            ['locale', '=', app()->getLocale()],
            ['group', '=', $product->category_id],
        ])->first();

        return view('app.product.single', [
            'product' => $product,
            'previous' => $product->getPrev(),
            'next' => $product->getNext(),
            'category' => $category,
            'components' => Component::where([
                ['locale', '=', app()->getLocale()],
                ['isVisible', '=', 1]
            ])->orderBy('title', 'asc')->get(),
            'recommended' =>  Product::getRandomProductsByCategory($category->group, 4),
        ]);
    }
}
