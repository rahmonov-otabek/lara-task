<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{ 
    public function creating(Category $category)
    {
        $category->slug = Str::slug($category->title_uz);
    }
 
    public function updating(Category $category)
    {
        if ($category->isDirty('title_uz')) {
            $category->slug = Str::slug($category->title_uz);
        }
    }
}
