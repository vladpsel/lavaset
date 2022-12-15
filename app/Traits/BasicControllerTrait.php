<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\Request;

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

}
