<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function index(FileHelper $fileHelper)
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
}
