<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{   use HasFactory; 

    protected $fillable = [
        'title', 'author', 'description', 'book_cover',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function tbrLists()
    {
        return $this->belongsToMany(User::class, 'tbr_lists');
    }
}