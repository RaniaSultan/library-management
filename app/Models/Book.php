<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author_id',
        'published_at',
        'available_copies'
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    
    public function borrowRequests()
    {
        return $this->hasMany(BorrowRequest::class);
    }
}
