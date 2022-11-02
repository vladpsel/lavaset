<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Http\Request;

class AdminComponentsController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var FileHelper
     */
    private FileHelper $fileHelper;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $locales;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
        $this->locales = config('app.available_locales');
    }

    public function index()
    {

        $component = new Component();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validated = $this->request->validate([
               'title' => 'required|min:1',
               'sort_order' => 'integer|min:1',
            ]);

            $data = $validated;
            $data['group'] = $component->getGroup();
            $data['picture'] = $this->fileHelper->uploadFile('icon', 'upload/components');

            foreach ($this->locales as $locale) {
                $data['locale'] = $locale;
                $single = $component->create($data);
                $result[] = $single;
            }
            return redirect()->route('admin.components')->with('message', 'Компонент додано!');

        }

        return view('admin.product-components.index', [
            'items' => $component->getLocaleGroupedItems(),
            'sort_number' => $component->getGroup(),
        ]);
    }
}
