<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'locale',
        'group',
        'picture',
        'title',
        'alias',
        'text',
        'link',
        'btn_title',
        'sort_order',
        'is_visible',
    ];

    private function getCommonFields()
    {
        return [
            'link' => $this->link,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
            'picture' => $this->picture,
            'alias' => $this->alias,
        ];
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

    public function getUpdateRules($key)
    {

        $alias = self::where('alias', $key)->first();

        if (empty($alias)) {
            $rules['alias'] = 'required|min:2|unique:posts';
            return $rules;
        }


        if ($alias->group === $this->group) {
            $rules['alias'] = 'required|min:2';
        } else {
            $rules['alias'] = 'required|min:2|unique:pages';
        }

        return $rules;
    }
}
