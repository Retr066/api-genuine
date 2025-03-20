<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'user_id',
    ];

    public function category()
    {
        return $this->hasOne(Categories::class);
    }

}
