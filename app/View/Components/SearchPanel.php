<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchPanel extends Component
{
    private ?array $items;
    private string $route;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?array $items, string $route)
    {
        $this->items = $items;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('admin.components.search-panel', [
            'items' => $this->items,
            'route' => $this->route,
        ]);
    }
}
