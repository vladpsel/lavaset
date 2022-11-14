<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\Request;

class FileHelper
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function uploadFile(string $key, string $path): ?string
    {
        if (!$this->request->file($key)) {
            return null;
        }

        $file = $this->request->file($key);
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        return $filename;
    }

    public function updateFile(?string $existFilename, string $key, string $path): ?string
    {
        if (!$this->request->file($key)) {
            return $existFilename;
        }

        if (!empty($existFilename) && $existFilename !== '' && file_exists($path . '/' . $existFilename)) {
            unlink(public_path($path . '/' . $existFilename));
        }

        $file = $this->request->file($key);
        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path($path), $filename);
        return $filename;
    }

    public function removeFile(?string $existFilename, string $path): ?bool
    {
        if (!$existFilename || $existFilename == '') {
            return null;
        }

        if (!empty($existFilename) && $existFilename !== '' && file_exists($path . '/' . $existFilename)) {
            unlink(public_path($path . '/' . $existFilename));
        }
        return null;
    }
}
