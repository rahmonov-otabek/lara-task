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
        'description_uz', 
        'description_ru', 
        'description_uzc', 
        'category_id'
    ]; 

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->hasMany(PostFiles::class, 'post_id');
    }
}
