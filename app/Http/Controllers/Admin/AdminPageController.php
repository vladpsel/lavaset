<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $page = new Page();
        $pages = $page->getLocaleGroupedPages();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validated = $this->request->validate([
                'title' => 'required|min:3',
                'alias' => 'required|min:3',
            ]);
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
            'alias' => 'required|min:3',
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
}
