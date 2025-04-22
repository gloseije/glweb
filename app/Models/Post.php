<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'media',
        'is_published',
        'content',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function category() : BelongsTo {
        return $this->BelongsTo(Category::class);
    }

    public function tags() : BelongsToMany {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function views() : HasMany {
        return $this->hasMany(View::class);
    } 
}
