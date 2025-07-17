<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name'];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_service');
    }
}
