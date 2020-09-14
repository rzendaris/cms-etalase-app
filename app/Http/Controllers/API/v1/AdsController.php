<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Table\MstAds;

class AdsController extends Controller
{
    public function GetAllAds()
    {
        $ads = MstAds::where('status', 1)->orderBy('orders', 'asc')->get();

        foreach($ads as $data){
            $data->picture = "pictures/".$data->picture;
        }
        return $this->appResponse(100, 200, $ads);
    }
}