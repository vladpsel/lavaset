<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'locale',
        'group',
        'alias',
        'isEditable',
    ];

    public function getLocaleGroupedPages()
    {
     $pages = self::all();
     $result = [];
     $counted = count($pages);

     for ($i = 0; $i < $counted; $i++) {
         foreach ($pages as $page) {
             if ($page->group === $i) {
                 $result[$i][] = $page;
             }
         }
     }

     return $result;
    }

    public function getGroup()
    {
        $locale = config('app.locale');
        $data = self::where('locale', $locale)->get();
        $group = count($data);
        return ++$group;
    }
}
