<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'title',
        'locale',
        'sort_order',
        'picture',
        'isVisible',
        'group',
    ];

    protected $attributes = [
        'isVisible' => 1,
    ];
}
