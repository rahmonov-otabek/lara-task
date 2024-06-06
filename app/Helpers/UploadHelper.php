<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\File; 
use App\Models\Category; 
use App\Models\Post;   
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;

class UploadHelper
{
    public static function uploadCategoryImages($request, Category $category)
    {
        if ($request->hasFile('images')) { 

            foreach ($request->file('images') as $image) {
                $imageName = time().".".$image->getClientOriginalName();
 
                $originalPath = public_path('uploads/category/original');
                $image->move($originalPath, $imageName); 
                 
                $imgManager = new ImageManager(new Driver()); 

                $thumbImage =  $imgManager->read($originalPath.'/'.$imageName);
 
                $thumbImage->resize(200, 200); 

                $thumbImage->save(public_path('uploads/category/200x200/'.$imageName)); 
                
                $thumbImage =  $imgManager->read($originalPath.'/'.$imageName);

                $thumbImage->resize(600, 600); 

                $thumbImage->save(public_path('uploads/category/600x600/'.$imageName)); 

                $category->images()->create([
                    "image" => $imageName,
                    "category_id" => $category->id
                ]); 
            }
 
        }
        } 

    public static function deleteOldCategoryImages(Category $category)
    {
        foreach ($category->images as $image) { 
            $orginalImagePath = public_path('uploads/category/orginal/'.$image->image);
            $smallImagePath = public_path('uploads/category/200x200/'.$image->image);
            $mediumImagePath = public_path('uploads/category/600x600/'.$image->image);  
         
            if(File::exists($orginalImagePath)){
                unlink($orginalImagePath);
            }
            if(File::exists($smallImagePath)){
                unlink($smallImagePath);
            }
            if(File::exists($mediumImagePath)){
                unlink($mediumImagePath);
            }
          }  
    }

    public static function uploadPostFiles($request, Post $post)
    {
        if ($request->hasFile('files')) { 

            foreach ($request->file('files') as $file) {
                $fileName = time().".".$file->getClientOriginalName();
 
                $extension = $file->getClientOriginalExtension();

                if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    $originalPath = public_path('uploads/post/images/original');
                    $file->move($originalPath, $fileName); 
                     
                    $imgManager = new ImageManager(new Driver()); 
    
                    $thumbImage =  $imgManager->read($originalPath.'/'.$fileName);
     
                    $thumbImage->resize(200, 200); 
    
                    $thumbImage->save(public_path('uploads/post/images/200x200/'.$fileName)); 
                    
                    $thumbImage =  $imgManager->read($originalPath.'/'.$fileName);
    
                    $thumbImage->resize(600, 600); 
    
                    $thumbImage->save(public_path('uploads/post/images/600x600/'.$fileName));
                    
                    $post->files()->create([
                        "file" => $fileName,
                        "type" => "image",
                        "post_id" => $post->id
                    ]); 
                } else {
                    $originalPath = public_path('uploads/post/files/');
                    $file->move($originalPath, $fileName); 

                    $post->files()->create([
                        "file" => $fileName,
                        "type" => "file",
                        "post_id" => $post->id
                    ]); 
                } 
            }

        }
    } 

    public static function deleteOldPostFiles(Post $post)
    {
        foreach ($post->files as $file) { 
            if ($file->type=="image") {
                $orginalImagePath = public_path('uploads/post/images/orginal/'.$file->file);
                $smallImagePath = public_path('uploads/post/images/200x200/'.$file->file);
                $mediumImagePath = public_path('uploads/post/images/600x600/'.$file->file);  
            
                if(File::exists($orginalImagePath)){
                    unlink($orginalImagePath);
                }
                if(File::exists($smallImagePath)){
                    unlink($smallImagePath);
                }
                if(File::exists($mediumImagePath)){
                    unlink($mediumImagePath);
                }
            }else {
                $orginalfilePath = public_path('uploads/post/files/'.$file->file); 
                
                if(File::exists($orginalfilePath)){
                    unlink($orginalfilePath);
                }
            }
        }  
    }

   
}