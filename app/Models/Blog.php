<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'image'
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ($value == null) ? null : asset('storage/blog/' . $value),
        );
    }

    public function scopeSlug($query,$slug)
    {
        $query->whereSlug($slug);
        return $query;
    }
}
