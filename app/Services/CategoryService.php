<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use UnexpectedValueException;

class CategoryService
{

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var Repository|Application|mixed
     */
    private mixed $locales;

    /**
     * @var FileHelper
     */
    private FileHelper $fileHelper;
    /**
     * @var string
     */
    private string $fileFolder;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->data = $this->request->except(['_token', 'submit']);
        $this->locales = config('app.available_locales');
        $this->fileHelper = $fileHelper;
        $this->fileFolder = 'upload/categories';
    }

    /**
     * @return array
     * @throws UnexpectedValueException
     */
    public function create(): array
    {
        $category = new Category();
        $result = [];

        $data = $this->data;

        if (!$data || empty($data) || !is_array($data)) {
            throw new UnexpectedValueException("Data for category doesn't match required type of value. Check data");
        }

        $data['group'] = $category->getGroup();
        $data['icon'] = $this->fileHelper->uploadFile('icon', $this->fileFolder);

        foreach ($this->locales as $locale) {
            $data['locale'] = $locale;
            $category = $category->create($data);
            $result[] = $category;
        }

        return $result;
    }

    /**
     * @param Category $category
     * @return bool
     * @throws UnexpectedValueException
     */
    public function update(Category $category): bool
    {
        $result = [];

        $data = $this->data;

        if (!$data || empty($data) || count($data) < 1) {
            throw new UnexpectedValueException("Data for category doesn't match required type of value. Check data");
        }

        $data['icon'] = $this->fileHelper->updateFile($category->icon, 'icon', $this->fileFolder);
        $category->update($data);
        $category->updateCommonFields($category);
        return true;

    }

    /**
     * @param Collection|null $category
     * @return bool|null
     */
    public function delete(?Collection $category): ?bool
    {
        if (!$category || count($category) < 1) {
            return null;
        }

        $deleteAsset = $this->fileHelper->removeFile($category[0]->icon, $this->fileFolder);
        foreach ($category as $item) {
            $item->delete();
        }
        return true;
    }


    /**
     * @param object $category
     * @return bool
     */
    public function checkAssetRemoving(object $category): bool
    {
        $key = 'icon';

        if ($this->request->has('remove_pic')) {
            $key = $this->request->input('remove_pic');
            $data[$key] = $this->fileHelper->removeFile($category->$key, $this->fileFolder);
            $category->update($data);
            $category->updateCommonFields($category);
            return true;
        }

        return false;
    }


    /**
     * @param array|bool $result
     * @return string
     */
    public function getOperationResult(array|bool|null $result): string
    {
        if (empty($result) || !$result) {
            return 'При створенні сталася помилка';
        }

        return 'Дані успішно оновлено';
    }

}
