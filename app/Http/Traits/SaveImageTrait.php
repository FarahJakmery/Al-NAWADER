<?php

namespace App\Http\Traits;

use App\Models\AdsImage;
use Intervention\Image\ImageManagerStatic as Image;

trait SaveImageTrait
{
    public function saveImage($photo, $folder, $width, $height)
    {
        // Saving The Image
        $imageExtension = $photo->getClientOriginalExtension();
        $image_name = time() . '.' . $imageExtension;
        $image_name_DataBase = $folder . '/' . time() . '.' . $imageExtension;
        Image::make($photo)->resize($width, $height)->save($folder . '/' . $image_name, 60);
        return $image_name_DataBase;
    }

    public function saveAdvertisementImage($Image, $folder, $width, $height, $advertisement)
    {
        // Store Image In Public Folder
        $imageExtension = $Image->getClientOriginalExtension();
        $image_name =  md5(rand(1000, 100000)) .  '.' . $imageExtension;
        $image_name_DataBase = $folder . '/' . $image_name;
        Image::make($Image)->resize($width, $height)->save($folder . '/' . $image_name, 60);

        // Store Image In Data_Base
        AdsImage::create([
            'advertisement_id'  => $advertisement->id,
            'image_name'        => $image_name_DataBase,
        ]);
    }
}
