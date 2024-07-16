<?php

namespace App\Http\Controllers\Auth;

use App\Models\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\AdminRegisterRequest;
use App\Http\Resources\Auth\AdminRegisterResource;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin',
         ['except' => ['login',"register",'verify']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('admin')->attempt($validator->validated())) {
            return response()->json(['message' => 'Invalid data'], 422);

            $admin = auth()->guard('admin')->user();

            // if (is_null($user->email_verified_at)) {
            //     return response()->json([
            //         'message' => 'Email not verified. Please verify it.'
            //     ], 403);
            // }
        }

        return $this->createNewToken($token);
    }

    /**
     * Register an Admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // Register an Admin.
    public function register(AdminRegisterRequest $request)
    {

        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $admin = Admin::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password), ]

        ));

        $admin->save();
        // $admin->notify(new EmailVerificationNotification());

        return response()->json([
            'message' => 'Admin Registration successful',
            'admin' =>new AdminRegisterResource($admin)
        ]);
    }


    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        return response()->json([
            'message' => 'Admin successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->guard('admin')->refresh());
    }

    /**
     * Get the authenticated Admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(["data" => auth()->guard('admin')->user()]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('admin')->factory()->getTTL() * 60,
            'admin' => auth()->guard('admin')->user(),
              'admin' => Admin::with('role:id,name')->find(auth()->id()),
        ]);
    }
}
