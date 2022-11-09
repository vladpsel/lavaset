<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{

    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $locale;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->locale = config('app.locale');
    }

    public function index()
    {
        $order = new Order();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $validated = $this->request->validate($order->validationRules);

            $data = $this->request->except('_token', 'submit');
            $data['details'] = json_encode($validated['details']);
            $data['products'] = json_encode($validated['products']);

            $created = $order->create($data);

            if ($created) {
                return redirect()->route('admin.orders');
            }
        }

        return view('admin.orders.index', [
            'items' => $order->all(),
            'conditions' => $order->orderConditions,
            'products' => Product::where('locale', $this->locale)->get(),
        ]);
    }
}
