<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = config('app.available_locales');

        foreach ($locales as $locale) {
            DB::table('pages')->insert([
                'locale' => $locale,
                'group' => 1,
                'alias' => '/',
                'title' => 'Головна',
                'isEditable' => null,
            ]);
        }
    }
}
