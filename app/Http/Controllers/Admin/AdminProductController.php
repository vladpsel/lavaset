<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    private Request $request;
    /**
     * @var \Illuminate\Config\Repository|Application|mixed
     */
    private mixed $locale;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->locale = config('app.locale');
    }

//alpha_dash

    public function index(): Factory|View|Application
    {
        $product = new Product();

        return view('admin.products.index', [
            'items' => $product->getLocaleGroupedItems(),
            'indicators' => $product->getWeightIndicators(),
            'sort_order' => $product->getGroup(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'components' => Component::where('locale', $this->locale)->get(),
        ]);
    }
}
