<?php

declare(strict_types=1);

function getLogo(): string
{
    $configFilepath = config_path() . '/theme.php';
    $config = include($configFilepath);

    if (!empty($config['logo']) && $config['logo'] !== '') {
        return '<img src="/upload/' . $config['logo'] . '" alt="' . $config['sitename'] .' logo">';
    }
    return '<img src="/dist/img/lavaset.svg" alt="' . $config['sitename'] .'">';
}

function getPages()
{
    return \App\Models\Page::where('locale', app()->getLocale())->get();
}

function getLink(?string $link): ?string
{
    $parts = explode('/', $link);
    $locale = array_shift($parts);

    if ($locale === config('app.fallback_locale')) {
        return implode('/', $parts);
    }

    return rtrim('/' . $link, '/');
}

function getLangList()
{
    return config('app.available_locales');
}

function getCategories()
{
    return \App\Models\Category::where([
        ['locale', '=', app()->getLocale()],
        ['isVisible', '=', 1]
    ])->orderBy('group', 'asc')->get();
}
