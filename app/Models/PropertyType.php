<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PropertyType
 *
 * Represents the type/category of a property (e.g., apartment, villa, shop).
 *
 * @package App\Models
 */
class PropertyType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $fillable = ['name'];

     /**
     * Get all properties that belong to this property type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
