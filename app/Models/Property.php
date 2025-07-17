<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{

    protected $fillable = [
        'name', 'location', 'rooms', 'area', 'price', 'description', 'status', 'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'type_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'property_service');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
