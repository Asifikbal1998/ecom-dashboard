<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_video',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public static function productFilters() {
        $productFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productFilters['sleeveArray'] = array('Full Sleve', 'Half Sleve', 'Short Sleve', 'Sleeveless');
        $productFilters['patternArray'] = array('Checked','Plain','Printed', 'Self', 'Solid');
        $productFilters['fitArray'] = array('Regular', 'Slim');
        $productFilters['occasionArray'] = array('Casual', 'Formal');
        return $productFilters;
    }
}
