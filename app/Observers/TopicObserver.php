<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body,'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
        //如果slug无内容则对title进行翻译
        if( !$topic->slug ){
//            dispatch(new TranslateSlug($topic));
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}