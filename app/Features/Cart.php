<?php

declare(strict_types=1);

namespace App\Features;

use App\Models\Product;

class Cart
{
    public function countProducts(?array $ids)
    {
        if (!$ids || empty($ids)) {
            return 0;
        }

        $result = 0;
        foreach ($ids as $key => $value) {
            $result += $value;
        }
        return $result;
    }

    public function getTotal()
    {
        $ids = session()->get('products');

        if (empty($ids)) {
            return null;
        }

        $products = Product::whereIn('group', array_keys($ids))->where('locale', app()->getLocale())->get()->toArray();

        if (!$products || empty($products)) {
            return null;
        }

        foreach ($products as $product => $data) {
            $result[$product] = $data;
            $result[$product]['quantity'] = $ids[$data['group']];
        }

        $price = 0;

        foreach ($result as $item) {
            $price += $item['price'] * $item['quantity'];
        }

        return $price;
    }

    public function clear()
    {
        session()->forget('products');
    }

}
