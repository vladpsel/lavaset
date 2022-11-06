<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', [
            'items' => [],
//            'indicators' => $product->getWeightIndicators(),
//            'sort_order' => $product->getGroup(),
//            'categories' => Category::where('locale', $this->locale)->get(),
//            'components' => Component::where('locale', $this->locale)->get(),
        ]);
    }
}
