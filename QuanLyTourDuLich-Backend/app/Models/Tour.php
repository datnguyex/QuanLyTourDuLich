<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Images;
use App\Models\Schedule;
class Tour extends Model
{
    use HasFactory;

    protected $table = "tours";

    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'start_date',
        'end_date',
        'location',
        'availability',
    ];


    public function images() {
        return $this->hasMany(Images::class, "tour_id" ,"id");
    }
    public function schedules() {
        return $this->hasMany(Schedule::class, "tour_id" ,"id");
    }

    /**
     * Extension method with FindByLocation
     * @param mixed $query
     * @param mixed $location
     * @return mixed
     */
    public function scopeFindByLocation($query, $location)
    {
        return $query->where('location', 'LIKE', '%' . $location . '%');
    }
    /**
     * Extension method with FindByCategory
     * @param mixed $query
     * @param mixed $category
     * @return mixed
     */
    public function scopeFindByCategory($query, $category)
    {
        return $query->where('category', 'LIKE', '%' . $category . '%');
    }
}