<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JwtHelper;
use App\Models\Staff;
use Exception;
use Illuminate\Http\JsonResponse;

class JwtFirebaseMiddleware
{
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Token tidak ditemukan'], 401);
        }

        $token = substr($authHeader, 7);
        $decoded = JwtHelper::decodeToken($token);
        
        if ($decoded instanceof JsonResponse) {
            return $decoded;
        }
    
        
        try {
            $decodedArray = (array) $decoded;
            $decodedArray['buat'] = date('Y-m-d H:i', $decodedArray['iat']);
            $decodedArray['waktu'] = date('Y-m-d H:i', $decodedArray['exp']);
            $staff = Staff::find($decoded->sub);

            if (!$staff) {
                return response()->json(['error' => 'User not found'], 404);
            }
            // Simpan user ke request supaya bisa dipakai di controller
            $request->merge(['auth_user' => $staff,'token'=>$decodedArray]);

        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid or expired token '.$e->getMessage()], 401);
        }

        return $next($request);
    }
}
