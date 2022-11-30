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

    private function getCommonFields()
    {
        return [
            'link' => $this->link,
            'sort_order' => $this->sort_order,
            'is_visible' => $this->is_visible,
            'left' => $this->left,
            'right' => $this->right,
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

    public function getBannerLink(?string $link)
    {

        if (preg_match('/^(http)s?/i', $link)) {
            return $link;
        };

        $link = trim($link, '/');

        return getLink(app()->getLocale() . '/' . $link);

    }

}
