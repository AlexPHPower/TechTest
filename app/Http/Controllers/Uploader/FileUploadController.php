<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Services\CSVService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $filePath = $this->handleFile($request);

        $csvService = new CSVService();

        $data = $csvService->formatData($filePath);

        foreach ($data as $datum) {
            Person::updateOrCreate(
                [
                'title' => $datum['title'], 'last_name' => $datum['last_name']
            ], [
                'title' => $datum['title'],
                'first_name' => $datum['first_name'],
                'initial' => $datum['initial'],
                'last_name' => $datum['last_name']
            ]);
        }

        $people = Person::all();

        return view('home.upload', [
            'people' => $people
        ]);
    }

    private function handleFile(Request $request): string
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $location = 'uploadedFiles';
        $file->move($location, $fileName);

        return public_path($location . '/' . $fileName);
    }
}
