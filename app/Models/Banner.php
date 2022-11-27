<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'locale',
        'group',
        'left',
        'right',
        'title',
        'text',
        'link',
        'btn_title',
        'sort_order',
        'is_visible',
    ];

    public array $validationRules = [
        ''
    ];

}
