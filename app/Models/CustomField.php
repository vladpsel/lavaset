<?php

namespace App\Models;

use App\Traits\FeatureTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory, BasicModelTrait;

    protected $fillable = [
        'locale',
        'group',
        'picture',
        'title',
        'text',
        'link',
        'btn_title',
        'sort_order',
        'is_visible',
        'related_group',
    ];

    private function getCommonFields()
    {
        return [
            'link' => $this->link,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
            'picture' => $this->picture,
            'related_group' => $this->related_group,
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
}
