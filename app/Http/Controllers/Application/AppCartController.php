<?php

namespace App\Http\Controllers\Application;

use App\Features\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppCartController extends Controller
{
    public function __construct(Request $request, Cart $cart)
    {
        $this->cart = $cart;
        $this->request = $request;
        $this->data = $request->except('_token', 'submit');
    }

    public function checkout()
    {
        $cart = new Cart();
        $productsInCart = session()->get('products');

        if (empty($productsInCart)) {
            return redirect('/');
        }

        $products = Product::whereIn('group', array_keys($productsInCart))->where('locale', app()->getLocale())->get();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validator = Validator::make(
                $this->request->all(),
                $cart::getValidationRules(),
                $cart::getValidationErrorMessages(),
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $this->data;
            $data['products'] = json_encode(Product::addProductQuantity($products->toArray(), $productsInCart));
            $data['details'] = json_encode($data['details']);
            $data['total'] = $cart->getTotal();
            $data['status'] = 'new';

            Order::create($data);
            session()->forget('products');

            return redirect('/');
        }

        return view('app.checkout', [
            'products' => $products,
            'cartProducts' => $productsInCart,
            'total' => $cart->getTotal(),
        ]);
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
