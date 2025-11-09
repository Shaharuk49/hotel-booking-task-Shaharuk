<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    protected $fillable = ['name', 'base_price'];
    
    // Relationship: One category has many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}