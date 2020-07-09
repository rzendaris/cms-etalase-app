<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function appResponse($responseCode, $data = null)
    {
        $responseMessage = self::handlingResponse($responseCode);
        $response = [
            'code' => $responseCode,
            'status' => $responseMessage,
            'data' => $data
            // 'memory_usage' => memory_get_usage()/1048576 . " mb"
        ];

        return response()->json($response);
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
            $message = "Wrong Username";
            break;
            case "106":
            $message = "Wrong Username or Password";
            break;
            case "1995":
            $message = "Access Denied";
            break;
            case "2000":
            $message = "Exception Handler";
            break;
            default:
                $message = "Response Code Undefined";
        }
        return $message;
    }
}
