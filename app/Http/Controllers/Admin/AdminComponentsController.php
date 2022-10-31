<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminComponentsController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var FileHelper
     */
    private FileHelper $fileHelper;

    public function __construct(Request $request, FileHelper $fileHelper)
    {
        $this->request = $request;
        $this->fileHelper = $fileHelper;
    }

    public function index()
    {
        return view('admin.components.index');
    }
}
