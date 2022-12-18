<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Services\ComponentService;
use App\Traits\BasicControllerTrait;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminComponentsController extends Controller
{

    use BasicControllerTrait;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var FileHelper
     */
    private FileHelper $fileHelper;
    /**
     * @var Repository|Application|mixed
     */
    private mixed $locales;
    private ComponentService $componentService;
    private string $redirectURI;

    public function __construct(Request $request, FileHelper $fileHelper, ComponentService $componentService)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
        $this->locales = config('app.available_locales');
        $this->componentService = $componentService;
        $this->redirectURI = 'admin.components';
    }

    public function index(): Factory|View|RedirectResponse|Application
    {
        $component = new Component();

        if ($this->postSubmitted()) {
            $validated = $this->request->validate($this->componentService->getValidationRules());
            $result = $this->componentService->create();
            return redirect()->route('admin.components')->with('message', $this->componentService->getOperationResult($result));
        }

        return view('admin.product-components.index', [
            'items' => $component->getLocaleGroupedItems(),
            'sort_number' => $component->getGroup(),
        ]);
    }

    public function update(int $id): Factory|View|RedirectResponse|Application
    {
        $component = Component::find($id);
        $this->checkEntity($component, $this->redirectURI);

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {
                $result = $this->componentService->checkAssetRemoving($component);
            }

            if ($this->request->has('submit')) {
                $validated = $this->request->validate($this->componentService->getValidationRules());
                $result = $this->componentService->update($component);
            }
            return back()->with('message', $this->componentService->getOperationResult($result));
        }

        return view('admin.product-components.update', [
            'component' => $component,
            'items' => $component->getLocaleGroupedItems(),
        ]);
    }

    public function delete(int $id): View|Factory|RedirectResponse|Application
    {
        $requested = Component::where('group', $id)->get();

        $this->checkEntity($requested, $this->redirectURI);

        if ($this->postSubmitted()) {
            $result = $this->componentService->delete($requested);
            return redirect()->route('admin.components')->with('message', $this->componentService->getOperationResult($result));
        }

        return view('admin.product-components.delete', [
            'requested' => $requested,
            'items' => (new Component())->getLocaleGroupedItems(),
        ]);
    }
}
