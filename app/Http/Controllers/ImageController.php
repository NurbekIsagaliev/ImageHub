<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {

        if (count($request->file('images')) > 5) {
            return redirect()->back()->with('error', 'Максимальное количество файлов для загрузки - 5.');
        }

        $files = $request->file('images');

        foreach ($files as $file) {

            $originalName = $file->getClientOriginalName();
            $filename = Str::lower(Str::slug(pathinfo($originalName, PATHINFO_FILENAME))) . '.' . $file->getClientOriginalExtension();


            $i = 1;
            while (Image::where('filename', $filename)->exists()) {

                $filename = Str::lower(Str::slug(pathinfo($originalName, PATHINFO_FILENAME))) . '_' . $i . '.' . $file->getClientOriginalExtension();
                $i++;
            }


            $file->move(public_path('images'), $filename);
            Image::create(['filename' => $filename, 'uploaded_at' => now()]);
        }


        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    public function showImages(Request $request)
    {
        $sort = $request->input('sort');

        if ($sort === 'name') {

            $images = Image::orderBy('filename')->get();

        } elseif ($sort === 'date') {

            $images = Image::orderBy('uploaded_at')->get();

        } else {

            $images = Image::all();
        }

        return view('show', ['images' => $images]);
    }

    public function downloadZip($id)
    {

        $image = Image::findOrFail($id);


        $zipFile = tempnam(sys_get_temp_dir(), 'image_') . '.zip';


        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);


        $imagePath = public_path('images/' . $image->filename);


        $zip->addFile($imagePath, $image->filename);


        $zip->close();


        return response()->download($zipFile, $image->filename . '.zip')->deleteFileAfterSend(true);
    }

    public function getAllImages()
    {
        $images = Image::all();
        return Response::json($images);
    }

    public function getImageById($id)
    {
        $image = Image::findOrFail($id);
        return Response::json($image);
    }
}
