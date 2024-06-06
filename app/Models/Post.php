<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_uz', 
        'title_ru', 
        'title_uzc', 
        'image', 
        'content_uz', 
        'content_ru', 
        'content_uzc', 
        'category_id'
    ]; 

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Post::class, 'post_id');
    }
}
