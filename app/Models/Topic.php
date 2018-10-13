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

    public function ScopeWithOrder($query,$order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            
            default:
                $query->recentReplied();
                break;
        }
        return $query->with('user','category');
    }
    public function ScopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }
    public function ScopeRecentReplied($query)
    {
        return $query->orderBy('updated_at','desc');
    }


}
