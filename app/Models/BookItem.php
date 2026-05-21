<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'item_code',
        'classification_code',
        'author_code',
        'title_code',
        'title_initial',
        'copy_number',
        'status',
        'condition',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}