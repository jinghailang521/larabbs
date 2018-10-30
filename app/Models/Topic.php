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
        //不同的排序使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            
            default:
                $query->recentReplied();
                break;
        }
        //预加载防止N+1
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
