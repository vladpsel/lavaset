<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Component;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use UnexpectedValueException;

class ComponentService
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
     * @var array
     */
    private array $data;

    /**
     * @var Repository|Application|mixed
     */
    private mixed $locales;

    /**
     * @var string
     */
    private string $fileFolder;

    /**
     * @var string
     */
    private string $assetKey;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
        $this->data = $this->request->except(['_token', 'submit']);
        $this->locales = config('app.available_locales');
        $this->fileFolder = 'upload/components';
        $this->assetKey = 'picture';
    }

    public function create(): ?array
    {
        $component = new Component();
        $result = null;

        $data = $this->data;

        if (!$data || empty($data) || !is_array($data)) {
            throw new UnexpectedValueException("Data for component doesn't match required type of value. Check data");
        }

        $data['group'] = $component->getGroup();
        $data['picture'] = $this->fileHelper->uploadFile($this->assetKey, $this->fileFolder);

        foreach ($this->locales as $locale) {
            $data['locale'] = $locale;
            $single = $component->create($data);
            $result[] = $single;
        }

        return $result;
    }

    public function update(Component $component)
    {
        $data = $this->data;

        if (!$data || empty($data) || count($data) < 1) {
            throw new UnexpectedValueException("Data for category doesn't match required type of value. Check data");
        }

        if (isset($component->picture)) {
            $data['picture'] = $this->fileHelper->updateFile($component->picture, $this->assetKey, $this->fileFolder);
        }

        $component->update($data);
        $result = $component->updateCommonFields($component);
        return true;
    }

    public function delete(?object $entitiesArr)
    {
        if (empty($entitiesArr) || !$entitiesArr) {
            return null;
        }

        $deleteAsset = $this->fileHelper->removeFile($entitiesArr[0]->icon, $this->fileFolder);

        foreach ($entitiesArr as $item) {
            $item->delete();
        }

        return true;
    }

    /**
     * @param object $component
     * @return bool
     */
    public function checkAssetRemoving(object $component): bool
    {
        if ($this->request->has('remove_pic')) {
            $key = $this->request->input('remove_pic');
            $data[$key] = $this->fileHelper->removeFile($component->$key, $this->fileFolder);
            $component->update($data);
            $component->updateCommonFields($component);
            return true;
        }

        return false;
    }

    /**
     * @return array[]
     */
    public function getValidationRules(): array
    {
        return [
            'title' => 'required|min:1',
            'sort_order' => 'integer|min:1',
        ];
    }

    public function getOperationResult($result): string
    {
        if (!$result || empty($result)) {
            return 'При створенні сталася помилка';
        }

        return 'Дані успішно оновлено';
    }

}
