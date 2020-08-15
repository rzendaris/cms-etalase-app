<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use App\Mail\SendMailResetPassword;
use App\Model\Tables\ResetPasswordToken;

use App\User;

class APIAuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'sdk_version' => 'required|string',
        ]);
        $check_user = User::where('email', $request->email)->where('role_id', 3)->first();
        if ($check_user){
            return $this->appResponse(505, 200);
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => 3,
                'password' => bcrypt($request->password),
                'eu_sdk_version' => $request->sdk_version
            ]);
            $user->save();
            return $this->appResponse(500, 200);
        }
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] user_id
     * @return [string] email
     * @return [string] name
     * @return [string] token
     */

    public function login(Request $request){
        try{
            $hasher = app()->make('hash');
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
                'sdk_version' => 'required'
            ]);
            $user = User::where('email', $request->email)->where('role_id', 3)->first();
            if(isset($user)){
                if($hasher->check($request->input('password'), $user->password)){
                    $apikey = $this->jwt($user);
                    $decode = JWT::decode($apikey, env('JWT_SECRET'), ['HS256']);
    
                    $data['user_email'] = $user->email;
                    $returnData = [
                        "user_id" => $user->id,
                        "email" => $user->email,
                        "name" => $user->name,
                        "role_id" => $user->role_id,
                        "token" => $apikey,
                    ];
                    User::where('id', $user->id)->update(['eu_sdk_version' => $request->sdk_version]);
                    return $this->appResponse(201, 200, $returnData);
                }else{
                    return $this->appResponse(105, 401);
                }
            }else{
                return $this->appResponse(105, 401);
            }
            
        } catch (Exception $e){
            return $this->appResponse(2000, 200);
        }
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->appResponse(202, 200);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = User::where('email', $request->user_email)->where('role_id', 3)->first();
        return $this->appResponse(100, 200, $user);
    }
  
    /**
     * Forgot Password
     *
     * @return [json] user object
     */

    public function forgotPassword(Request $request)
    {
        $email = $request->email;
        if ($email == ""){
            return $this->appResponse(106, 200);
        }
        $user = User::where('email', $request->email)->first();
        if(isset($user)){
            $token = md5(rand(1, 50) . microtime());
            $now_time = Carbon::now();
            $expired = Carbon::parse($now_time->toDateTimeString())->addHour();
            $data = array(
                'email' => $request->email,
                'name' => $user->name,
                'reset_url' => url('forgot-password-verify/'.$token),
            );
            Mail::send(new SendMailResetPassword($data));
            ResetPasswordToken::create([
                'email' => $request->email,
                'token' => $token,
                'expired_at' => $expired
            ]);
            return $this->appResponse(200, 200, "Periksa email anda!");
        } else {
            return $this->appResponse(106, 200);
        }
    }
}