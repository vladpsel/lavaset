<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, BasicModelTrait;

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
