<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->slug = Str::slug($post->title_uz);
    }
 
    public function updating(Post $post)
    {
        if ($post->isDirty('title_uz')) {
            $post->slug = Str::slug($post->title_uz);
        }
    }
}
