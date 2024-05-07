<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        // Add other fillable fields here if any
        'categori_image',
    ];

    public function parentcategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'parent_id')->select('id', 'categori_name', 'url')->where('status', 1);
    }

    public function subCategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }

    public function getCategoriesWithSubcategories()
    {
        return Category::with(['subCategories' => function ($query) {
            $query->with('subCategories');
        }])->where('parent_id', 0)->where('status', 1)->get();
    }
}
