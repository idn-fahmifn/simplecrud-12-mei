<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'uuid', 'stock', 'image', 'desc', 'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
