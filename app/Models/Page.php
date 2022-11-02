<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'locale',
        'group',
        'alias',
        'isEditable',
    ];

    protected $attributes = [
        'isEditable' => 1,
    ];

//    public function getLocaleGroupedPages()
//    {
//     $pages = self::all();
//     $result = [];
//     $counted = count($pages);
//
//     for ($i = 0; $i < $counted; $i++) {
//         foreach ($pages as $page) {
//             if ($page->group === $i) {
//                 $result[$i][] = $page;
//             }
//         }
//     }
//
//     return $result;
//    }

    public function getUpdateRules(self $page, $key)
    {

        $rules = [
            'title' => 'required|min:2',
        ];

        if ($page->isEditable === null) {
            return $rules;
        }

        $alias = self::where('alias', $key)->first();


        if (empty($alias)) {
            $rules['alias'] = 'required|min:2|unique:pages';
            return $rules;
        }


        if ($alias->group === $page->group) {
            $rules['alias'] = 'required|min:2';
        } else {
            $rules['alias'] = 'required|min:2|unique:pages';
        }

        return $rules;
    }

    public function updateCommonFields(self $page)
    {
        $pages = self::where([
            ['group', '=', $page->group],
            ['id', '!=', $page->id],
        ])->get();

        foreach ($pages as $single) {
            $single->update($this->getCommonFields($page));
        }

        return $pages;
    }

    private function getCommonFields(self $page) {
        return [
            'alias' => $page->alias,
        ];
    }

}
