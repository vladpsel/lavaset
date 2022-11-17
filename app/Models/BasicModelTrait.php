<?php

declare(strict_types=1);

namespace App\Models;

trait BasicModelTrait
{
    /**
     * Function for items in admin-aside__bar.
     * @return array
     */
    public function getLocaleGroupedItems(): array
    {
        $data = self::all();
        $result = [];
        $counted = count($data);


        for ($i = 0; $i < $counted; $i++) {
            foreach ($data as $item) {
                if ($item->group == $i) {
                    $result[$i][] = $item;
                }
            }
        }
        return $result;
    }

    /**
     * Get group id for entity
     * @return int
     */
    public function getGroup(): int
    {
        $locale = config('app.locale');
        $data = self::where('locale', $locale)->get();
        $group = count($data);
        return ++$group;
    }

}
