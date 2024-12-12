<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titol' => 'required|max:255',
            'descripcio' => 'required',
            'img' => 'required'
        ]);

        // Post::create([
        //     'titol' => $request->titol,
        //     'descripcio' => $request->descripcio,
        //     'img' => $request->img,
        //     'user_id' => auth()->user()->id
        // ]);

        //altra manera de crear registres
        // $post = new Post;
        // $post->titol = $request->titol;
        // $post->descripcio = $request->descripcio;
        // $post->img = $request->img;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        //altra manera amb relacions
        $request->user()->posts()->create([
            'titol' => $request->titol,
            'descripcio' => $request->descripcio,
            'img' => $request->img,
            'user_id' => auth()->user()->id
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        $imatge_path = public_path('uploads/' . $post->img);

        if (File::exists($imatge_path)) {
            unlink($imatge_path);
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
