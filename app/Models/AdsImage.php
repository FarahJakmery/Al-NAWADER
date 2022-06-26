<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsImage extends Model
{
    use HasFactory;

    protected $table = 'ads_images';
    protected $fillable = ['advertisement_id', 'image_name'];
}
