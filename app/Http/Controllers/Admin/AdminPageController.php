<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class AdminPageController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(): View|Factory|Application|RedirectResponse
    {
        $page = new Page();
        $pages = $page->getLocaleGroupedPages();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $rules = [
                'title' => 'required|min:2',
                'alias' => 'required|min:1|unique:pages',
            ];

            $errors = [
                'title.min' => 'Занадто коротке значення',
                'alias.min' => 'Занадто коротке значення',
                'alias.unique' => 'Аліас повинен бути унікальним, таке значення вже існує',
            ];

            $validated = $this->request->validate($rules, $errors);
            $page = new Page();
            $data = $validated;
            $data['group'] = $page->getGroup();

            $locales = config('app.available_locales');

            foreach ($locales as $locale) {
                $data['locale'] = $locale;
                $page = $page->create($data);
                $result[] = $page;
            }
            return redirect()->route('admin.pages');
        }


        return view('admin.pages.index', [
            'pages' => $pages,
        ]);
    }
    public function create()
    {
        $data = $this->request->input('data');
        if (empty($data)) {
            return response()->json([
                'message' => 'No valid data',
                'code' => 500,
            ], 500);
        }

        $validated = Validator::make($data, [
            'title' => 'required|min:3',
            'alias' => 'required|min:2|unique:pages',
        ]);

        $page = new Page();
        $data['group'] = $page->getGroup();

        $locales = config('app.available_locales');

        foreach ($locales as $locale) {
            $data['locale'] = $locale;
            $page = $page->create($data);
            $result[] = $page;
        }

        return response()->json($result);
    }

    public function update(int $id)
    {
        $page = Page::find($id);

        if (!$page) {
            return redirect()->route('admin.pages');
        }
        $pages = $page->getLocaleGroupedPages();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $rules = $page->getUpdateRules($page, $this->request->input('alias'));

            $errors = [
                'title.min' => 'Занадто коротке значення',
                'alias.min' => 'Занадто коротке значення',
                'alias.unique' => 'Аліас повинен бути унікальним, таке значення вже існує',
            ];

            $validated = $this->request->validate($rules, $errors);

            $page->update($validated);
            $page->updateCommonFields($page);
            return back()->with('message', 'Сторінку успішно оновлено');
        }

        return view('admin.pages.update', [
            'single' => $page,
            'pages' => $pages,
        ]);
    }
}
