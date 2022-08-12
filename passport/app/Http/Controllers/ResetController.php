<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetController extends Controller
{
    //
    public function resetpassword(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = Hash::make($request->password);

        $emailcheck = DB::table('password_resets')->where('email', $email)->first();
        $pincode = DB::table('password_resets')->where('token', $token)->first();

        if (!$emailcheck) {
            return response([
                'message' => "Email Not Found"
            ], 400);
        }

        if (!$pincode) {
            return response([
                'message' => "Token Not Found"
            ], 400);
        }

        DB::table('users')->where('email', $email)->update(['password' => $password]);
        DB::table('password_resets')->where('email', $email)->delete();

        return response([
            'message' => "Password Change Successfully"
        ], 200);
    }
}
