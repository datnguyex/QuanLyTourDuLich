<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashSecret extends Model
{
    use HasFactory;

     /**
      *  Hàm mã hóa
      * @param mixed $id
      * @return string
      */
    static function encrypt($id)
    {
        $secretKey = env('SECRET_KEY', 'tourtravelstore');
        $cipher = 'AES-256-CBC';
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
        // Mã hóa ID
        $encrypted = openssl_encrypt($id, $cipher, $secretKey, 0, $iv);

        // Trả về mã hóa kèm IV để giải mã sau này
        return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * Hàm giải mã
     * @param mixed $data
     * @return bool|string
     */
    static function decrypt($data)
    {
        $secretKey = env('SECRET_KEY', 'tourtravelstore');
        $cipher = 'AES-256-CBC';

        list($encryptedData, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encryptedData, $cipher, $secretKey, 0, $iv);
    }
}