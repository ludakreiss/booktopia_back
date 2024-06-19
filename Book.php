<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'author', 'description', 'book_cover',
    ];

    /**
     * Get the genres associated with the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }

    /**
     * Get the reviews associated with the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the users who have this book in their to-be-read list.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tbrLists()
    {
        return $this->belongsToMany(User::class, 'tbr_lists');
    }
}
