<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\verifyAccountMail;
use Illuminate\Http\Request;
use App\Http\Requests\{
    LoginRequest, CreateUser
};
use Illuminate\Support\Facades\{
    DB, Mail, Hash, Http
};
use App\Util\CustomResponse;
use App\Http\Resources\UserResource;

class AuthService
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $user = User::where("email", $request->email)->first();
            if(!$user || !password_verify($request->password, $user->password)):
                $message = "Wrong credentials";
                return CustomResponse::error($message, 400);
            elseif((int)$user->is_verified !== 1):
                $message = "Email address not verified, please verify your email before you can login";
                return CustomResponse::error($message, 401);
            endif;

            $token = $user->createToken("softlibrary")->plainTextToken;
            $user->token = $token;
            $message = 'Login successfully';
            $user = new UserResource($user);
            return CustomResponse::success($message, $user);
        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }
    }

    public function register(CreateUser $request): \Illuminate\Http\JsonResponse
    {
        try{
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $code = mt_rand(1000, 9999);
            $expiry_time = Carbon::now()->addMinutes(6);
            DB::table('user_verification')
                ->insert([
                    'email' => $user->email, 
                    'code' => $code, 
                    'expiry_time' => $expiry_time
                ]);
            Mail::to($user->email)->send(new verifyAccountMail($user, $code));

        }catch(\Exception $e){
            $message = $e->getMessage();
            return CustomResponse::error($message);
        }

        $message = 'Thanks for signing up! Please check your email to complete your registration.';
        $user = new UserResource($user);
        return CustomResponse::success($message, $user, 201);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return CustomResponse::success("User has been logged out", null);
    }

    public function refresh(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });

        $token = $user->createToken("softlibrary")->plainTextToken;

        return CustomResponse::success("token refreshed successfully", $token);
    }
}
