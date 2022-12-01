<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Category;
use App\Models\CustomField;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminCustomFieldsController extends Controller
{

    private Request $request;
    private array $data;
    private FileHelper $file;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private mixed $locale;
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
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

        $custom = new CustomField();
        $group = $custom->getGroup();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $data = $this->data;
            $data['picture'] = $this->file->uploadFile('picture', 'upload/custom-fields');
            $data['group'] = $group;

            foreach ($this->locales as $locale) {
                $data['locale'] = $locale;
                $banner = $custom->create($data);
                $result[] = $banner;
            }
            return redirect()->route('admin.modules.fields');
        }


        return view('admin.modules.custom-fields.all', [
            'items' => $custom->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
            'sort_order' => $group,
            'groups' => CustomField::where('locale', $this->locale)->get(),
        ]);
    }

    public function update(int $id)
    {
        $custom = CustomField::find($id);

        if (!$custom || empty($custom)) {
            return redirect()->route('admin.modules.fields');
        }

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {
                $key = $this->request->input('remove_pic');
                $data[$key] = $this->file->removeFile($custom->$key, '/upload/custom-fields');
            }

            if($this->request->has('submit')) {
                $data = $this->data;
                $data['picture'] = $this->file->updateFile($custom->picture, 'picture', 'upload/custom-fields');
            }

            $custom->update($data);
            $custom->updateCommonFields($custom);
            return back()->with('message', 'Поле успішно оновлено');

        }

        return view('admin.modules.custom-fields.item', [
            'custom' => $custom,
            'items' => $custom->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
            'groups' => CustomField::where('locale', $this->locale)->get(),
        ]);
    }
}
