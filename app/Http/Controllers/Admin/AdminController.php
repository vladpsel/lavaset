<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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

    public function settings(FileHelper $fileHelper)
    {
        $configFilepath = config_path() . '/theme.php';
        $config = include($configFilepath);

        if ($this->request->isMethod('post')) {
            if ($this->request->has('submit')) {
               $data = $this->request->except(['submit', '_token']);
               $data['favicon'] = $fileHelper->updateFile($config['favicon'], 'favicon', 'upload');
               $data['logo'] = $fileHelper->updateFile($config['logo'], 'logo', 'upload');
           }

           if ($this->request->has('remove-logo')) {
               $data = $config;
               $data['logo'] = $fileHelper->removeFile($data['logo'], 'upload');
           }

            if ($this->request->has('remove-icon')) {
                $data = $config;
                $data['favicon'] = $fileHelper->removeFile($data['favicon'], 'upload');
            }

            $data = var_export($data, true);
            file_put_contents($configFilepath, "<?php\n return {$data};\n");
            return redirect()->back();
        }

        return view('admin.settings', [
            'config' => $config,
        ]);
    }

}
