<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Expectation;

class ForgetController extends Controller
{
    //

    public function forgetpassword(ForgetRequest $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'messege' => 'Email Invalid'
            ], 401);
        }

        $token = rand(10, 100000);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);
            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'message' => "Reset password mail send on your email"
            ], 200);
        } catch (Expectation $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
