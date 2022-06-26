<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Section extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = ['icon_name', 'photo_name'];
    public $translatedAttributes = ['section_name'];

    /**
     * Get the categories for the section.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the advertisements for the section.
     */
    public function advertisements()
    {
        return $this->hasMany(Advertisements::class);
    }
}
