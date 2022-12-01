<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\CustomField;
use Illuminate\Http\Request;

class AppPageController extends Controller
{
    public function delivery()
    {
     return view('app.delivery',[
         'title' => CustomField::where([
             ['locale', '=', app()->getLocale()],
             ['is_visible', '=', 1],
             ['related_group', '=', 'delivery_title']
         ])->first(),
         'items' => CustomField::where([
             ['locale', '=', app()->getLocale()],
             ['is_visible', '=', 1],
             ['related_group', '=', 'delivery']
         ])->orderBy('sort_order', 'asc')->get(),
     ]);
    }
}
