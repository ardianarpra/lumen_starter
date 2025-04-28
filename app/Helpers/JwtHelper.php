<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;

class JwtHelper
{
    protected static $key = 'your-secret-keya'; // simpan di .env lebih baik

    public static function generateToken($payload)
    {

        $timezone = new \DateTimeZone('Asia/Makassar');
        $issuedAtRaw = new \DateTime('now', $timezone);
        $issuedAt = $issuedAtRaw->getTimestamp(); 
        $expirationTime = $issuedAt + 60 * 60; // 1 jam
        $token = JWT::encode(array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
        ]), self::$key, 'HS256');

        return $token;
    }

    public static function encode($payload)
    {
        return JWT::encode($payload, self::$key, 'HS256');
    }

    public static function decodeToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (ExpiredException $e) {
            // Token expired (exp)
            return response()->json([
                'error' => 'Token sudah kedaluwarsa',
            ], 401);
        
        } catch (BeforeValidException $e) {
            // Token digunakan sebelum iat/nbf (not before)
            return response()->json([
                'error' => 'Token belum bisa digunakan',
            ], 401);
        
        } catch (SignatureInvalidException $e) {
            // Signature tidak valid (key salah atau dimodifikasi)
            return response()->json([
                'error' => 'Signature token tidak valid',
            ], 401);
        
        } catch (UnexpectedValueException $e) {
            // Token tidak bisa di-decode (format salah, rusak, kosong, dsb.)
            return response()->json([
                'error' => 'Token tidak valid: ' . $e->getMessage(),
            ], 401);
        
        } catch (\Exception $e) {
            // Error tak terduga lainnya
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
