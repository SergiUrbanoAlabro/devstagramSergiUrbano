<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentari extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'comentari'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
