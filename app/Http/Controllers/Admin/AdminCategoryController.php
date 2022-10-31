<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{

    private Request $request;
    private array $data;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->data = $this->request->except(['_token', 'submit']);
    }

    public function index(FileHelper $fileHelper): View|Factory|Application|RedirectResponse
    {
        $category = new Category();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validRules = $category->getValidationRules($category, $this->request->input('alias'));
            $locales = config('app.available_locales');

            $validated = $this->request->validate($validRules['rules'], $validRules['messages']);

            $data = $this->data;
            $data['group'] = $category->getGroup();
            $data['icon'] = $fileHelper->uploadFile('icon', 'upload/categories');
            foreach ($locales as $locale) {
                $data['locale'] = $locale;
                $category = $category->create($data);
                $result[] = $category;
            }
            return redirect()->route('admin.categories');
        }

        return view('admin.categories.index', [
            'items' => $category->getLocaleGroupedItems(),
        ]);
    }

    public function update(int $id, FileHelper $fileHelper): View|Factory|RedirectResponse|Application
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories');
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validRules = $category->getValidationRules($category, $this->request->input('alias'));
            $locales = config('app.available_locales');

            $validated = $this->request->validate($validRules['rules'], $validRules['messages']);
            $data = $this->data;
            $data['icon'] = $fileHelper->updateFile($category->icon, 'icon', 'upload/categories');

            $category->update($data);
            $category->updateCommonFields($category);
            return back()->with('message', 'Сторінку успішно оновлено');
        }

        return view('admin.categories.update', [
            'category' => $category,
            'items' => $category->getLocaleGroupedItems(),
        ]);
    }

    public function delete(int $id, FileHelper $fileHelper)
    {
        $requested = Category::where('group', $id)->get();

        if (count($requested) < 1) {
            return back();
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $data['icon'] = $fileHelper->removeFile($requested[0]->icon, 'upload/categories');
            foreach ($requested as $item) {
                $item->delete();
            }
            return redirect()->route('admin.categories');
        }

        $category = (new Category())->getLocaleGroupedItems();

        return view('admin.categories.delete', [
            'requested' => $requested,
            'items' => $category,
        ]);
    }


}
