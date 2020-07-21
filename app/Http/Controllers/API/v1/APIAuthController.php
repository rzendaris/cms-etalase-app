<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
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
                'password' => 'required'
            ]);
            $user = User::where('email', $request->email)->where('role_id', 2)->first();
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
        $user = User::where('email', $request->user_email)->where('role_id', 2)->first();
        return $this->appResponse(100, 200, $user);
    }
}