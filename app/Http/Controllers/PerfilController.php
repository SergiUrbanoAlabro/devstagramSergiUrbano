<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil', '']
        ]);

        if ($request->img) {
            $manager = new ImageManager(new Driver());
            $imatge = $request->file('img');

            $nomImg = Str::uuid() . "." . $imatge->extension();

            $imgServidor = $manager->read($imatge);
            $imgServidor->cover(1000, 1000);

            $imgPath = public_path('perfils') . '/' . $nomImg;
            $imgServidor->save($imgPath);
        }

        //Guardar Canvis
        $usuari = User::find(auth()->user()->id);
        $usuari->username = $request->username;
        $usuari->img = $nomImg ?? auth()->user()->img ?? '';

        $usuari->save();

        return redirect()->route('posts.index', $usuari->username);
    }
}
