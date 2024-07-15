<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ichtrojan\Otp\Otp;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    private $otp;
    public function __construct(){
        $this->otp = new Otp;
    }

        public function resetPassword(ResetPasswordRequest $request){
            $otp2 =$this->otp->validate($request->email,$request->otp);
            if (!$otp2->status){
                return response()->json(['error' => $otp2],401);
            }
            $user = User::where('email',$request->email)->first();
            $user->update(['password'=>Hash::make($request->password)]);
            // $user->tokens()->delete();


            return response()->json([
                'message' => "The password reset successfully."
            ]);

        }
}
