<?php

namespace App\Http\Controllers;

use App\Helpers\JwtHelper;
use App\Http\Middleware\JwtFirebaseMiddleware;
use App\Models\Mahasiswa;
use App\Models\Staff;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class StaffController extends Controller
{
    public function register(Request $request){

        try {
            DB::beginTransaction();
            $staff = Staff::create([
                "nama" => $request->nama,
                "email" => $request->email,
                'password' => Hash::make($request->password),
                "nip" => $request->nip,
                "jabatan" => $request->jabatan,
            ]);
            
            $emailService = new EmailService();
            $emailService->sendRegisterSuccess($staff->email, $staff->nama);
            $payload = ['sub'=>$staff->id, 'nama' => $staff->nama];
    
            $token = JwtHelper::generateToken($payload);

            DB::commit();
            return response()->json(compact('staff','token'),201);
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            $message = $th->getMessage();
            return response()->json(compact('message'),500);
        }
        
    }

    public function login(Request $request){
        $staff = Staff::where('nip',$request->nip)->first();

        if (!$staff || !Hash::check($request->password, $staff->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        
        $payload = ['sub' => $staff->id, 'nama' => $staff->nama];

        $token = JwtHelper::encode([
            'sub' => $staff->id,
            'exp' => time() + (60 * 60),
        ]);

        return response()->json(compact('payload','token'));
    }

    public function me(Request $request)
    {
        return response()->json($request);
    }
}
