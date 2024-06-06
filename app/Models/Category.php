<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_uz', 
        'title_ru', 
        'title_uzc', 
        'description_uz', 
        'description_ru', 
        'description_uzc',  
        'parent_id'
    ];
  
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function images()
    {
        return $this->hasMany(CategoryImages::class, 'category_id');
    }
}
