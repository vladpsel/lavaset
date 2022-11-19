<?php

namespace App\Http\Controllers\Application;

use App\Features\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AppCartController extends Controller
{
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function checkout()
    {
        return view('app.checkout');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request)
    {

        $data = (int) $request->input('data');
        $increment = 1;

        if (!$data) {
            return response()->json([
                'message' => 'Невірні параметри запиту',
                'status' => 403
            ], 403);
        }

        $products = session()->get('products');

        if (!isset($products["$data"])) {
            $products[$data] = $increment;
        } else {
            $count = $products[$data];
            $products[$data] = $count + $increment;
        }

        $request->session()->put('products', $products);
        return response()->json($this->cart->countProducts($products));
    }

    public function set(Request $request)
    {
        $data = $request->input('data');

        if (!$data || $data['quantity'] <= 0) {
            return response()->json([
                'message' => 'Not valid request',
            ], 403);
        }

        $ids = session()->get('products');

        if (empty($ids)) {
            return response()->json('', 404);
        }

        $ids[$data['id']] = $data['quantity'];
        session()->put('products', $ids);

        return response()->json([
            'counted' => $this->cart->countProducts($ids),
            'total' => $this->cart->getTotal(),
        ]);
    }

    public function remove($id)
    {
        $products = session()->get('products');

        if (empty($products) || !isset($products[$id])) {
            return null;
        }

        unset($products[$id]);
        session()->put('products', $products);
        return back();
    }


}
