<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'locale',
        'title',
        'alias',
        'icon',
        'description',
        'keywords',
        'isVisible',
        'group',
    ];

    protected $attributes = [
        'isVisible' => 1,
    ];

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

//    public function getLocaleGroupedItems()
//    {
//        $pages = self::all();
//        $result = [];
//        $counted = count($pages);
//
//        for ($i = 0; $i < $counted; $i++) {
//            foreach ($pages as $page) {
//                if ($page->group === $i) {
//                    $result[$i][] = $page;
//                }
//            }
//        }
//
//        return $result;
//    }

    public function getGroup(): int
    {
        $locale = config('app.locale');
        $data = self::where('locale', $locale)->get();
        $group = count($data);
        return ++$group;
    }

    public function getValidationRules(self $page, string $key): array
    {
        $data = [
            'rules' => [
                'title' => 'required|min:2',
            ],
            'messages' => [
                ':attribute.required' => "Це поле обов`язкове для заповнення",
            ]
        ];

        $alias = self::where('alias', $key)->first();

        if (empty($alias)) {
            $data['rules']['alias'] = 'required|min:2|unique:categories';
            return $data;
        }

        if ($alias->group === $page->group) {
            $data['rules']['alias'] = 'required|min:2';
        } else {
            $data['rules']['alias'] = 'required|min:2|unique:pages';
        }

        return $data;
    }

    private function getCommonFields(self $page): array
    {
        return [
            'alias' => $page->alias,
            'icon' => $page->icon,
        ];
    }
}
