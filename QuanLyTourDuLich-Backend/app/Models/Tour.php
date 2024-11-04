<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
    public function images()
    {
        return $this->hasMany(Images::class, 'tour_id');
    }
    public static function getTourDetailWithImages($tourId)
    {
        return self::with('images')->find($tourId);
    }
    public static function getLatestTours()
    {
        return self::with('images')->orderBy('created_at', 'desc')->get();
    }
    private function encryptId($id, $key) {
        $method = 'AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
        $encryptedId = openssl_encrypt($id, $method, $key, 0, $iv);
        return base64_encode($iv . $encryptedId);
    }
    
    private function decryptId($encryptedId, $key) {
        $method = 'AES-256-CBC';
        
        $decodedUrl = urldecode($encryptedId);
        $decodedData = base64_decode($decodedUrl);
        $ivLength = openssl_cipher_iv_length($method);
        $iv = substr($decodedData, 0, $ivLength);
        $encryptedIdWithoutIv = substr($decodedData, $ivLength);
        
        return openssl_decrypt($encryptedIdWithoutIv, $method, $key, 0, $iv);
    }

}