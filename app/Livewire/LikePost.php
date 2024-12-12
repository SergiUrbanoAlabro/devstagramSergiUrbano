<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)
    {
        $this->post = $post;
        $this->isLiked = $post->checkLike(Auth::user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if ($this->isLiked) {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
            $this->likes++;
        }
        $this->isLiked = !$this->isLiked;
    }
    public function render()
    {
        return view('livewire.like-post');
    }
}
