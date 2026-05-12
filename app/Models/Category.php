<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_name', 'uuid'
    ];
}
