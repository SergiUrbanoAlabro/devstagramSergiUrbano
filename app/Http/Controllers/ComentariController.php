<?php

namespace App\Http\Controllers;

use App\Models\Comentari;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentariController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        $this->validate($request, [
            'comentari' => 'required|max:255'
        ]);

        Comentari::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentari' => $request->comentari
        ]);

        return back()->with('missatge', 'Comentari Realitzat Correctament');
    }
}
