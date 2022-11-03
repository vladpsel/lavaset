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

}
