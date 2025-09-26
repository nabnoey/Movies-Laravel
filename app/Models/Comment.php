<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // กำหนด column ที่สามารถ mass assign ได้
    protected $fillable = [
        'user_id',
        'movie_id',
        'body',
        'rating',
    ];

    // ความสัมพันธ์กับ User
  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}