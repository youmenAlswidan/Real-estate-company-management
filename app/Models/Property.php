<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Property
 *
 * Represents a real estate property in the system.
 * Contains relationships to type, images, services, reservations, and reviews.
 *
 * @package App\Models
 */
    class Property extends Model    
    {

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'location', 'rooms', 'area', 'price', 'description', 'status', 'type_id','visiting_hours'
    ];

    /**
    * Get the property type associated with the property.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'type_id');
    }

    /**
    * Get all images related to the property.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
    * Get all services associated with the property.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'property_service');
    }

    /**
    * Get all reservations made for the property.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    
    /**
    * Get all reviews for the property.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
