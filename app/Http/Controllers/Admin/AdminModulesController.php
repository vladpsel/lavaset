<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class AdminModulesController extends Controller
{
    private Request $request;
    private array $data;
    private FileHelper $file;
    /**
     * @var Repository|Application|mixed
     */
    private mixed $locale;
    /**
     * @var Repository|Application|mixed
     */
    private mixed $locales;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->data = $request->except(['_token', 'submit']);
        $this->file = $fileHelper;
        $this->locale = config('app.locale');
        $this->locales = config('app.available_locales');
    }

    public function index()
    {

//        $modulesFiles = scandir(base_path() . DIRECTORY_SEPARATOR .'modules');
//        unset($modulesFiles[0], $modulesFiles[1]);

        return view('admin.modules.index', [
            'items' => [
                [
                    'title' => 'Банери',
                    'url' => 'admin.modules.banners',
                ]
            ]
        ]);
    }


    public function banners()
    {
        $banner = new Banner();
        $group = $banner->getGroup();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $data = $this->data;
            $data['left'] = $this->file->uploadFile('left', 'upload/banners');
            $data['right'] = $this->file->uploadFile('right', 'upload/banners');
            $data['group'] = $group;

            foreach ($this->locales as $locale) {
                $data['locale'] = $locale;
                $banner = $banner->create($data);
                $result[] = $banner;
            }
            return redirect()->route('admin.modules.banners');
        }

        return view('admin.modules.banners.all', [
            'items' => $banner->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
            'sort_order' => $group,
        ]);
    }

    public function bannersUpdate(int $id)
    {
        $banner = Banner::find($id);

        if (!$banner || empty($banner)) {
            return redirect()->route('admin.modules.banners');
        }

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {

            }

            if($this->request->has('submit')) {
                $data = $this->data;

                $data['left'] = $this->file->updateFile($banner->left, 'left', 'upload/banners');
                $data['right'] = $this->file->updateFile($banner->right, 'right', 'upload/banners');
                $banner->update($data);
                $banner->updateCommonFields($banner);
                return back()->with('message', 'Товар успішно оновлено');
            }


        }

        return view('admin.modules.banners.item', [
            'banner' => $banner,
            'items' => $banner->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
        ]);
    }

    public function bannersDelete(int $id)
    {
        $requested = Banner::where('group', $id)->get();

        if (count($requested) < 1) {
            return back();
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $this->file->removeFile($requested[0]->left, 'upload/banners');
            $this->file->removeFile($requested[0]->right, 'upload/banners');

            foreach ($requested as $item) {
                $item->delete();
            }
            return redirect()->route('admin.modules.banners')->with('message', 'Банер було видалено');
        }

        return view('admin.modules.banners.delete', [
            'requested' => $requested,
            'items' => $requested[0]->getLocaleGroupedItems(),
        ]);
    }


}
