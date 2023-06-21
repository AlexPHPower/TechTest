<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $location = 'uploadedFiles';
        $file->move($location, $fileName);
        $filePath = public_path($location . '/' . $fileName);

        $people = [];

        $handle = fopen($filePath, "r");

        if ($handle !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                $last_name = null;

                if (str_contains($data[0], 'and') || str_contains($data[0], '&')) {
                    $nameParts = explode(' ', $data[0]);
                    $last_name = end($nameParts);
                }

                if (str_contains($data[0], '&')) {
                    $names = explode(' & ', $data[0]);
                } else {
                    $names = explode(' and ', $data[0]);
                }

                foreach ($names as $name) {
                    if ($name === 'homeowner') {
                        continue;
                    }
                    $nameParts = explode(' ', $name);

                    if (count($nameParts) > 2) {
                        $personNames = explode(' ', $name);

                        $title = $personNames[0];

                        if (is_null($last_name)) {
                            $last_name = end($personNames);
                        }

                        foreach ($personNames as $index => $personName) {
                            // Skip the title and last name
                            if ($index === 0 || $index === count($personNames) - 1) {
                                continue;
                            }

                            $person = [
                                'title' => $title,
                                'first_name' => null,
                                'initial' => null,
                                'last_name' => $last_name,
                            ];

                            if (strpos($personName, '.') !== false || Str::length($personName) < 2) {
                                $person['initial'] = preg_replace('/[.]/', '', $personName);
                            } else {
                                $person['first_name'] = $personName;
                            }

                            $people[] = $person;
                        }
                    } else {
                        $person = [
                            'title' => $nameParts[0],
                            'first_name' => null,
                            'initial' => null,
                            'last_name' => $last_name ?? end($nameParts),
                        ];

                        if (count($nameParts) > 1) {
                            if (str_contains($nameParts[1], '.') || Str::length($personName) < 2) {
                                $person['initial'] = preg_replace('/[.]/', '', $nameParts[1]);
                            } else {
                                $person['first_name'] = $nameParts[1] = $last_name ? null : $nameParts[1];
                            }
                        }

                        $people[] = $person;
                    }
                }
            }

            fclose($handle);
        }

        return view('home.upload', [
            'people' => $people
        ]);
    }
}
