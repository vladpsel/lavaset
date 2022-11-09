<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'name',
        'phone',
        'details',
        'comment',
        'products',
        'total',
        'status',
    ];

    protected $attributes = [
        'name' => '',
        'phone' => '',
    ];

    public array $validationRules = [
        'name' => 'required',
        'phone' => 'required',
        'details' => 'present',
        'products' => 'present',
    ];

    public array $orderConditions = [
        'new' => 'Новий',
        'process' => 'В обробці',
        'waiting' => 'Очікує підтвердження',
        'assemble' => 'Комплектується',
        'waitforpay' => 'Очікує оплати',
        'waitfordelivery' => 'Готовий до відправки',
        'ontheway' => 'Доставляється',
        'payed' => 'Оплачено',
        'done' => 'Виконано',
        'closed' => 'Закрито',
        'canseled' => 'Відмінено',
    ];
//    public function getValidationRules()
}
