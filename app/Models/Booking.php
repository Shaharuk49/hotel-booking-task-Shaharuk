<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'room_category_id',
        'from_date', 
        'to_date', 
        'nights',
        'base_price', 
        'weekend_surcharge', 
        'discount', 
        'final_price'
    ];

    // Relationship: Each booking belongs to one room category
    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }
}