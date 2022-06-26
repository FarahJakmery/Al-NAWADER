<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Advertisement extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $table = 'advertisements';
    protected $fillable = ['posted_by', 'section_id', 'category_id'];
    public $translatedAttributes = ['text'];

    /**
     * Get the section that owns the advertisement.
     */
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Get the category that owns the advertisement.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
