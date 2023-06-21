<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $location = 'uploadedFiles';
        $file->move($location, $fileName);
        $filePath = public_path($location . '/' . $fileName);
    }
}
