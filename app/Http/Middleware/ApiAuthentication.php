<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;

class ApiAuthentication
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $start_time = microtime(true);
        $token = $request->header('jwt');
        
        if($token == null) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => "API Key is Missing"
            ], 403);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $request->user_email = $credentials->sub->email;
            $request->username = $credentials->sub->name;
            $request->sdk_version = $credentials->sub->eu_sdk_version;
            $request->user_id = $credentials->sub->id;
            return $next($request)->header('Cache-Control', 'no-cache, must-revalidate');
        } catch(\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'message' => "API Key is Expired"
            ], 403);
        } catch(\Firebase\JWT\SignatureInvalidException $e) {
            return response()->json([
                'message' => "Signature verification failed"
            ], 403);
        } catch(\Firebase\JWT\Exception $e) {
            return response()->json([
                'message' => "API Key is Something Went Wrong"
            ], 403);
        } catch (Exception $e) {
            return response()->json([
                'message' => "API Key is Something Went Wrong"
            ], 403);
        }

        return $next($request)->header('Cache-Control', 'no-cache, must-revalidate');

    }

}
