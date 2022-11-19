<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminModulesController extends Controller
{
    public function index()
    {

        $modulesFiles = scandir(base_path() . DIRECTORY_SEPARATOR .'modules');
        unset($modulesFiles[0], $modulesFiles[1]);

        dump($modulesFiles);

        return view('admin.modules.index');
    }
}
