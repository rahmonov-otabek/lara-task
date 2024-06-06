<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\File; 
use App\Models\Category;  
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\GD\Driver;

class UploadHelper
{
    public static function uploadCategoryImages($request, Category $category)
    {
        if ($request->hasFile('images')) { 

            foreach ($request->file('images') as $image) {
                $imageName = time().".".$image->getClientOriginalName();
 
                $originalPath = public_path('images/category/original');
                $image->move($originalPath, $imageName); 
                 
                $imgManager = new ImageManager(new Driver()); 

                $thumbImage =  $imgManager->read($originalPath.'/'.$imageName);
 
                $thumbImage->resize(200, 200); 

                $thumbImage->save(public_path('images/category/200x200/'.$imageName)); 
                
                $thumbImage =  $imgManager->read($originalPath.'/'.$imageName);

                $thumbImage->resize(600, 600); 

                $thumbImage->save(public_path('images/category/600x600/'.$imageName)); 

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
            $orginalImagePath = public_path('images/category/orginal/'.$image->image);
            $smallImagePath = public_path('images/category/200x200/'.$image->image);
            $mediumImagePath = public_path('images/category/600x600/'.$image->image);  
         
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

   
}