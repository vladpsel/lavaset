<?php

declare(strict_types=1);

use App\Features\Cart;

function getLogo(): string
{
    $configFilepath = config_path() . '/theme.php';
    $config = include($configFilepath);

    if (!empty($config['logo']) && $config['logo'] !== '') {
        return '<img src="/upload/' . $config['logo'] . '" alt="' . $config['sitename'] .' logo">';
    }
    return '<img src="/dist/img/lavaset.svg" alt="' . $config['sitename'] .'">';
}

function getIcon(): ?string
{
    $configFilepath = config_path() . '/theme.php';
    $config = include($configFilepath);

    if (!empty($config['favicon']) && $config['favicon'] !== '') {
        return $config['favicon'];
    }

    return null;
}

function getTitle()
{
    $configFilepath = config_path() . '/theme.php';
    $config = include($configFilepath);

    if (!empty($config['sitename']) && $config['sitename'] !== '') {
        return $config['sitename'];
    }
    return null;
}

function getPages()
{
    return \App\Models\Page::where('locale', app()->getLocale())->get();
}

function getLink(?string $link): ?string
{
    $parts = explode('/', trim($link, '/'));
    $locale = array_shift($parts);

    if (!in_array($locale, config('app.available_locales'))) {
        return '/' . trim($link, '/');
    }

    if ($locale === config('app.fallback_locale')) {
        return '/' . implode('/', $parts);
    }

    return '/' . trim($link, '/');

}

function getLangList()
{
    return config('app.available_locales');
}

//function normalizeLangLink($lang, $link)
//{
//    return '/' . $lang . '/' . $link;
//
////    if ($lang === config('app.fallback_locale')) {
////        $link = trim($link, '/');
////    }
////    return trim($link, '/');
//}

function getCategories()
{
    return \App\Models\Category::where([
        ['locale', '=', app()->getLocale()],
        ['isVisible', '=', 1]
    ])->orderBy('group', 'asc')->get();
}

function getCartCounted()
{
    $cart = new Cart();
    return  $cart->countProducts(session()->get('products'));
}

function getCuttedText(string $string)
{
    $string = strip_tags($string);
    $string = substr($string, 0, 200);
    $string = rtrim($string, "!,.-");
    $string = substr($string, 0, strrpos($string, ' '));
    return $string . '...';
}
