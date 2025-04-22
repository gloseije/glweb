<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'ip_address',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
