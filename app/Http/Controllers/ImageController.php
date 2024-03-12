<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Str;
class ImageController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $files = $request->file('images');

        foreach ($files as $file) {
            $filename = Str::lower(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            Image::create(['filename' => $filename, 'uploaded_at' => now()]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }
}
