<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['image_path', 'property_id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
