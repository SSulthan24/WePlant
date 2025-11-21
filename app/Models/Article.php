<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'tag',
        'status',
        'views',
        'user_id',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
