<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Firebase\JWT\JWT;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function jwt($user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*3600 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    
    public static function CheckApkPackage($filename) {
        $apk = new \ApkParser\Parser('apk/'.$filename);
        $manifest = $apk->getManifest();
        $permissions = $manifest->getPermissions();
        $data = array(
            "package_name" => $manifest->getPackageName(),
            "version_name" => $manifest->getVersionName(),
            "version_code" => $manifest->getVersionCode(),
            "min_sdk_level" => $manifest->getMinSdkLevel(),
            "min_sdk_platform" => $manifest->getMinSdk()->platform,
        );
        return $data;
    }
    
    public static function MapPublicPath() {
        $path = public_path().'/';
        if (env('DEPLOYMENT_STATUS', 0) == 1){
            $path = "";
        }
        return $path;
    }

    public static function appResponse($responseCode, $httpCode = 200, $data = null)
    {
        $responseMessage = self::handlingResponse($responseCode);
        $response = [
            'code' => $responseCode,
            'message' => $responseMessage,
            'data' => $data
            // 'memory_usage' => memory_get_usage()/1048576 . " mb"
        ];

        return response()->json($response, $httpCode)->header('Cache-Control', 'no-cache, must-revalidate');
    }

    /**
     * Handling Response Code And Message
     * 
     * @param Response Code $response_code
     * @return Array Response
     */

    public static function handlingResponse($response_code)
    {
        $message = "";
        switch ($response_code) {
            case "100":
                $message = "Showing Data Success";
            break;
            case "101":
                $message = "Showing Data Failed";
            break;
            case "156":
                $message = "User not found";
            break;
            case "200":
                $message = "Request Success";
            break;
            case "201":
                $message = "Login Success";
            break;
            case "202":
                $message = "Successfully logged out";
            break;
            case "300":
                $message = "Token Passed";
            break;
            case "301":
                $message = "Token is not valid";
            break;
            case "302":
                $message = "Token is Expired";
            break;
            case "500":
                $message = "Data Successfully Created";
            break;
            case "501":
                $message = "Data Successfully Updated";
            break;
            case "502":
                $message = "Data Successfully Deleted";
            break;
            case "504":
                $message = "Error sending data";
            break;
            case "505":
                $message = "Data Already Exist!";
            break;
            case "600":
                $message = "New Token Successfully Created";
            break;
            case "601":
                $message = "New Token on this ID Successfully updated";
            break;
            case "602":
                $message = "Current Token is not expired yet!";
            break;
            case "104":
                $message = "Data not Found!";
            break;
            case "105":
                $message = "Incorrect Username or Password";
            break;
            case "106":
                $message = "Email not Registered";
            break;
            case "1995":
                $message = "Access Denied";
            break;
            case "2000":
                $message = "Something went wrong. Please try again later.";
            break;
            default:
                $message = "Response Code Undefined";
        }
        return $message;
    }
}
