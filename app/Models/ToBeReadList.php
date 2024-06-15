<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToBeReadList extends Model
{
    use HasFactory;
    protected $table = 'to_be_read_list';

    protected  $fillable = [
        'user_id', 'book_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
