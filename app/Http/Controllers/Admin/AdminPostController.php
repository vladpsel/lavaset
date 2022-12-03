<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class AdminPostController extends Controller
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

        $post = new Post();
        $group = $post->getGroup();

        if ($this->request->isMethod('post') && $this->request->has('submit')) {

            $validated = $this->request->validate([
                'alias' => 'required|unique:posts'
            ]);

            $data = $this->data;
            $data['picture'] = $this->file->uploadFile('picture', 'upload/posts');
            $data['group'] = $group;

            foreach ($this->locales as $locale) {
                $data['locale'] = $locale;
                $post = $post->create($data);
                $result[] = $post;
            }
            return redirect()->route('admin.posts');
        }

        return view('admin.posts.index', [
            'items' => $post->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
            'sort_order' => $group,
        ]);
    }

    public function update(int $id)
    {
        $post = Post::find($id);

        if (!$post || empty($post)) {
            return redirect()->route('admin.modules.banners');
        }

        if ($this->request->isMethod('post')) {

            if ($this->request->has('remove_pic')) {
                $key = $this->request->input('remove_pic');
                $data[$key] = $this->file->removeFile($post->$key, '/upload/posts');
            }

            if($this->request->has('submit')) {
                $validated = $this->request->validate($post->getUpdateRules($post->alias));
                $data = $this->data;
                $data['picture'] = $this->file->updateFile($post->left, 'picture', 'upload/posts');
            }

            $post->update($data);
            $post->updateCommonFields($post);
            return back()->with('message', 'Публікацію успішно оновлено');

        }

        return view('admin.posts.update', [
            'post' => $post,
            'items' => $post->getLocaleGroupedItems(),
            'pages' => Page::where('locale', $this->locale)->get(),
            'categories' => Category::where('locale', $this->locale)->get(),
            'products' => Product::where('locale', $this->locale)->get(),
            'sort_order' => $post->sort_order,
        ]);
    }

    public function delete(int $id)
    {
        $requested = Post::where('group', $id)->get();

        if (count($requested) < 1 || empty($requested)) {
            return back();
        }

        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            foreach ($requested as $item) {
                $item->delete();
            }
            return redirect()->route('admin.posts');
        }

        $posts = (new Post())->getLocaleGroupedItems();

        return view('admin.posts.delete', [
            'requested' => $requested,
            'items' => $posts,
        ]);
    }
}
