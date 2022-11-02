<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Component;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
     * @var \Illuminate\Config\Repository|Application|mixed
     */
    private mixed $locales;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
        $this->locales = config('app.available_locales');
    }

    public function index(): Factory|View|RedirectResponse|Application
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

    public function update(int $id)
    {
        $component = Component::find($id);

        if (!$component) {
            return redirect()->route('admin.components');
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            $validated = $this->request->validate([
                'title' => 'required|min:1',
                'sort_order' => 'integer|min:1',
                'isVisible' => 'present',
            ]);

            $validated['picture'] = $this->fileHelper->updateFile($component->picture, 'icon', 'upload/components');
            $component->update($validated);
            $component->updateCommonFields($component);

            return back()->with('message', 'Сторінку успішно оновлено');
        }

        return view('admin.product-components.update', [
            'component' => $component,
            'items' => $component->getLocaleGroupedItems(),
        ]);
    }
}
