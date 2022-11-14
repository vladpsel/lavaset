<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
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
    private FileHelper $fileHelper;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->locale = config('app.locale');
        $this->locales = config('app.available_locales');
        $this->fileHelper = $fileHelper;
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
                'sort_order' => 'present',
            ]);

            $data = $validated;
            $data['components'] = json_encode($this->request->input('components'));
            $data['picture'] = $this->fileHelper->uploadFile('picture', 'upload/product');
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

    public function update(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('admin.products');
        }

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {
                $updated = $this->fileHelper->removeFile($product->picture, 'upload/product');
                if ($updated) {
                    $product->update(['picture' => null]);
                }
                return back();
            }

            if ($this->request->has('submit')) {
                $validated = $this->request->validate([
                    'title' => 'required',
                    'alias' => $product->getAliasRule(),
                    'description' => 'present',
                    'price' => 'required',
                    'weight' => 'present',
                    'parameter' => 'present',
                    'picture' => 'image',
                    'category_id' => 'required',
                    'sort_order' => 'present',
                    'is_visible' => 'present',
                ]);

                $data = $validated;
                $data['components'] = json_encode($this->request->input('components'));
                $data['picture'] = $this->fileHelper->updateFile($product->picture, 'picture', 'upload/product');
                $product->update($data);
                $product->updateCommonFields($product);
                return back()->with('message', 'Товар успішно оновлено');
            }

        }

        return view('admin.products.update', [
            'entity' => $product,
            'items' => $product->getLocaleGroupedItems(),
            'indicators' => $product->getWeightIndicators(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'components' => Component::where('locale', $this->locale)->get(),
            'itemComponents' => $product->getComponents(json_decode($product->components, true)),
        ]);
    }

    public function delete(int $id): View|Factory|RedirectResponse|Application
    {
        $requested = Product::where('group', $id)->get();

        if (count($requested) < 1) {
            return back();
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            foreach ($requested as $item) {
                $item->delete();
            }
            return redirect()->route('admin.products')->with('message', 'Товар було видалено');
        }

        return view('admin.products.delete', [
            'requested' => $requested,
            'items' => (new Product())->getLocaleGroupedItems(),
        ]);
    }

}
