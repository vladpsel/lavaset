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
    ];

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

    private function getCommonFields(): array
    {
        return [
            'alias' => $this->alias,
            'picture' => $this->icon,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'weight' => $this->weight,
            'parameter' => $this->parameter,
            'components' => $this->components,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
        ];
    }

}
