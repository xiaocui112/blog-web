<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

class TopicObserver
{
   public function saving(Topic $topic)
   {
       $this->editContent($topic);
   }
   public function updating(Topic $topic)
   {
        $this->editContent($topic);
   }
   public function updated(Topic $topic)
   {
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
   }
   public function saved(Topic $topic)
   {
        if (!$topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
   }
   public function editContent(Topic $topic)
   {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
   }
   public function deleting(Topic $topic)
   {
       $topic->replies()->delete();
   }
}
