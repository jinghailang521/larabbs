<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'excerpt','category_id','slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
