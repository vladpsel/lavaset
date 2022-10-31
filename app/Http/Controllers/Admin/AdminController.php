<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    public function removePicture(string $path, string $file = null, FileHelper $fileHelper)
    {
        if (empty($path) || empty($file)) {
            return back();
        }

        $fileHelper->removeFile($file, 'upload/' . $path);
        return back();
    }

}
