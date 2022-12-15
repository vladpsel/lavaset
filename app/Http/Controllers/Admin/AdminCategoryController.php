<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Services\CategoryService;
use App\Traits\BasicControllerTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{

    use BasicControllerTrait;

    private Request $request;
    private array $data;
    private CategoryService $categoryService;

    public function __construct(Request $request, CategoryService $categoryService)
    {
        $this->request = $request;
        $this->data = $this->request->except(['_token', 'submit']);
        $this->categoryService = $categoryService;
    }

    public function index(): View|Factory|Application|RedirectResponse
    {
        $category = new Category();

        if ($this->postSubmitted()) {
            $validationInfo = $category->getValidationRules($this->request->input('alias'));
            $validated = $this->request->validate($validationInfo['rules'], $validationInfo['messages']);

            $categories = $this->categoryService->create();
            return redirect()->route('admin.categories')->with('message', $this->categoryService->getOperationResult($categories));
        }

        return view('admin.categories.index', [
            'items' => $category->getLocaleGroupedItems(),
        ]);
    }

    public function update(int $id): View|Factory|RedirectResponse|Application
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories');
        }

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {
                $result = $this->categoryService->checkAssetRemoving($category);
            }

            if($this->request->has('submit')) {
                $validationInfo = $category->getValidationRules($this->request->input('alias'));
                $validated = $this->request->validate($validationInfo['rules'], $validationInfo['messages']);
                $result = $this->categoryService->update($category);
            }

            return redirect()->route('admin.categories.single', $id)->with('message', $this->categoryService->getOperationResult($result));

        }

        return view('admin.categories.update', [
            'category' => $category,
            'items' => $category->getLocaleGroupedItems(),
        ]);
    }

    public function delete(int $id): Factory|View|RedirectResponse|Application
    {
        $requested = Category::where('group', $id)->get();

        if (count($requested) < 1) {
            return back();
        }

        if ($this->postSubmitted()) {
            $result = $this->categoryService->delete($requested);
            return redirect()->route('admin.categories')->with('message', $this->categoryService->getOperationResult($result));
        }

        return view('admin.categories.delete', [
            'requested' => $requested,
            'items' => (new Category())->getLocaleGroupedItems(),
        ]);
    }


}
