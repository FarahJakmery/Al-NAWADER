<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = ['section_id', 'icon_name', 'photo_name'];
    public $translatedAttributes = ['category_name'];

    /**
     * Get the section that owns the category.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the advertisements for the category.
     */
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
