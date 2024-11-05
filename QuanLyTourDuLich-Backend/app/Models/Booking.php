<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "booking";

    protected $fillable = [
        "tour_id",
        "customer_id",
        "booking_date",
        "number_of_tikers",
        "user_id",
        "tour_guide_id",
    ];


}