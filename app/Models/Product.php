<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'locale',
        'group',
        'category_id',
        'title',
        'alias',
        'description',
        'price',
        'weight',
        'parameter',
        'picture',
        'components',
        'sort_order',
        'is_visible',
    ];

    protected $attributes = [
        'is_visible' => 1,
        'category_id' => null,
    ];

    private function getCommonFields(): array
    {
        return [
            'alias' => $this->alias,
            'picture' => $this->picture,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'weight' => $this->weight,
            'parameter' => $this->parameter,
            'components' => $this->components,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
        ];
    }

    public function getWeightIndicators()
    {
        return [
            0 => 'гр',
            1 => 'кг',
            2 => 'мл',
            3 => 'л',
            4 => 'шт',
        ];
    }

    public function getComponents(?array $components): array
    {
        if (empty($components)) {
            return [];
        }
        return $components;
    }

    public function getAliasRule()
    {
        $alias = self::where('alias', $this->alias)->first();

        if (empty($alias)) {
            return 'required|min:2|unique:products';
        }

        if ($alias->group === $this->group) {
            return 'required|min:2';
        } else {
            return 'required|min:2|unique:products';
        }
    }

    public function updateCommonFields()
    {
        $pages = self::where([
            ['group', '=', $this->group],
            ['id', '!=', $this->id],
        ])->get();

        foreach ($pages as $single) {
            $single->update($this->getCommonFields());
        }

        return $pages;
    }

    public static function getRandomProductsByCategory($categoryId, $length = 8): ?array
    {
        $scope = self::where([
            ['locale', app()->getLocale()],
            ['category_id', $categoryId],
        ])->get()->toArray();

        if (empty($scope) || count($scope) < 1) {
            return null;
        }

        shuffle($scope);

        return array_splice($scope, 0, $length);
    }

    public static function getWeightIndicator($index)
    {
        switch ($index) {
            case '0': return __('base.indicator.zero');
            case '1': return __('base.indicator.one');
            case '2': return __('base.indicator.two');
            case '3': return __('base.indicator.three');
            case '4': return __('base.indicator.four');
            case '5': return __('base.indicator.five');
        }
    }

    public function getPrev()
    {
        $id = $this->group;
        $prev = null;

        for ($i = --$id; $i !== 0; $i--) {
            $prev = self::where([
                ['locale', '=', app()->getLocale()],
                ['group', '=', $i],
            ])->first();

            if (!empty($prev)) {
                return $prev;
            }
        }
        return $prev;
    }

    public function getNext()
    {
        $id = $this->group;
        $total = self::where([
            ['locale', '=', app()->getLocale()],
        ])->count();

        $next = null;

        for ($i = $id; $i <= $total; $i++) {
        $next = self::where([
                ['locale', '=', app()->getLocale()],
                ['group', '=', ++$i],
            ])->first();

            if (!empty($next)) {
                return $next;
            }
        }
        return $next;
    }

    public static function addProductQuantity($products, $params)
    {
        $result = [];
        foreach ($products as $product => $data) {
            $result[$product]['group'] = $data['group'];
            $result[$product]['title'] = $data['title'];
            $result[$product]['price'] = $data['price'];
            $result[$product]['quantity'] = $params[$data['group']];
        }
        return $result;
    }

    public function inProducts($id, $products)
    {
        foreach ($products as $product) {
            if ($product['group'] == $id) {
                return 'true';
            }
        }
        return false;

    }

    public function getCurrent($id, $products)
    {
        foreach ($products as $product) {
            if ($product['group'] == $id) {
                return $product;
            }
        }
        return null;
    }

}
