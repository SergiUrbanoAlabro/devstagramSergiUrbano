<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImatgeController extends Controller
{
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());
        $imatge = $request->file('file');

        $nomImg = Str::uuid() . "." . $imatge->extension();

        $imgServidor = $manager->read($imatge);
        $imgServidor->cover(1000, 1000);

        $imgPath = public_path('/uploads') . '/' . $nomImg;
        $imgServidor->save($imgPath);

        return response()->json(['imatge' => $nomImg]);
    }
}
