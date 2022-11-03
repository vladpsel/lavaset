<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    private Request $request;
    /**
     * @var \Illuminate\Config\Repository|Application|mixed
     */
    private mixed $locale;
    /**
     * @var \Illuminate\Config\Repository|Application|mixed
     */
    private mixed $locales;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->locale = config('app.locale');
        $this->locales = config('app.available_locales');
    }

    public function index(): View|Factory|Application|RedirectResponse
    {
        $product = new Product();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validated = $this->request->validate([
                'title' => 'required',
                'alias' => 'required|min:2',
                'description' => 'present',
                'price' => 'required',
                'weight' => 'present',
                'parameter' => 'present',
                'picture' => 'image',
                'category_id' => 'required',
                'sort_order' => 'present',
            ]);

            $data = $validated;
            $data['components'] = json_encode($this->request->input('components'));
            $data['group'] = $product->getGroup();

            foreach ($this->locales as $locale) {
                $data['locale'] = $locale;
                $page = $product->create($data);
                $result[] = $page;
            }
            return redirect()->route('admin.products');
        }

        return view('admin.products.index', [
            'items' => $product->getLocaleGroupedItems(),
            'indicators' => $product->getWeightIndicators(),
            'sort_order' => $product->getGroup(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'components' => Component::where('locale', $this->locale)->get(),
        ]);
    }
}
