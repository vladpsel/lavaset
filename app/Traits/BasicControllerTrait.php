<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

trait BasicControllerTrait
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function postSubmitted(): bool
    {
        if ($this->request->isMethod('post') && $this->request->has('submit')) {
            return true;
        }
        return false;
    }

    public function checkEntity(mixed $entity, string $redirectURI): ?RedirectResponse
    {

        if (!$entity || empty($entity)) {
            return redirect()->route($redirectURI)->send();
        }

        if (is_array($entity) && count($entity) < 1) {
            return redirect()->route($redirectURI)->send();
        }

        return null;
    }

}
