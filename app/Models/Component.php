<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $data)
 */
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
            'sort_order' => $page->sort_order,
            'picture' => $page->picture,
            'isVisible' => $page->isVisible,
        ];
    }

}
