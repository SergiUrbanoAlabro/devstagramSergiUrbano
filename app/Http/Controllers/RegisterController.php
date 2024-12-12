<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // dd($request);
        // dd($request->get('email'));

        //Modificar Request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validacio amb laravel
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        //Autenticar usuaris
        auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        //altra manera
        // auth()->attempt(only('email', 'password'));

        return redirect()->route('posts.index');
    }
}
