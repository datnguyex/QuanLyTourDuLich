<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'profile_picture',
        'gender',
        'dob',
    ];
    
    // Nếu cần, bạn có thể thêm các mối quan hệ ở đây
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}