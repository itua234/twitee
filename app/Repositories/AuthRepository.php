<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\{
    User
};
use App\Util\CustomResponse;
use App\Interfaces\IAuthInterface;
use Illuminate\Support\Facades\{
    DB, Mail, Hash
};
use Illuminate\Http\Request;
use App\Http\Requests\{
    VerifyAccount, ChangePassword
};

class AuthRepository implements IAuthInterface
{
    public function verifyUser(VerifyAccount $request)
    {
        $check = DB::table('user_verification')->where(['email' => $request->email, 'code' => $request->code])->first();
        $current_time = Carbon::now();
        try{
            switch(is_null($check)):
                case(false):
                    if($check->expiry_time < $current_time):
                        $message = 'Verification code is expired';
                    else:
                        $user = User::where('email', $check->email)->first();
                        User::where('id', $user->id)->update(['is_verified' => 1, 'email_verified_at' => $current_time]);
                        DB::table('user_verification')->where('code', $request->code)->delete();

                        $message = 'Your email address is verified successfully.';
                        return CustomResponse::success($message, null);
                    endif;
                break;
                default:
                    $message = "Verification code is invalid.";
            endswitch;
        }catch(\Exception $e){
            $error_message = $e->getMessage();
            return CustomResponse::error($error_message);
        }
    }

    
    public function change_password(ChangePassword $request)
    {
        $user = auth()->user();
        try{
            if((Hash::check($request->old_password, $user->password)) == false):
                $message = "Check your old password.";
            elseif((Hash::check($request->new_password, $user->password)) == true):
                $message = "Please enter a password which is not similar to your current password.";
            else:
                $user->password = $request->new_password;
                $user->save();
                $message = "Your password has been changed successfully";
                return CustomResponse::success($message, null);
            endif;
        }catch(\Exception $e){
            $error_message = $e->getMessage();
            return CustomResponse::error($error_message);
        }
        
        return CustomResponse::error($message, 400);
    }
}