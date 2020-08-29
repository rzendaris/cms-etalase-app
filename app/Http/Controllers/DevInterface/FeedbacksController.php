<?php

namespace App\Http\Controllers\DevInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\Ratings;
use App\Model\Table\Apps;

class FeedbacksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (Auth::user()->role_id != 1){
        //         return redirect('/')->with('access_message', 'Akses untuk Menu User Management Ditolak!');
        //     }
        //     return $next($request);
        // });

    }

    public function FeedbacksInit()
    {
        $ratings = Ratings::with(['endusers','apps'])->where('users_dev_id',Auth::user()->id)->get();
        $ratingsall = Ratings::with(['endusers','apps'])->get();
        $avgrating = Ratings::where('users_dev_id',Auth::user()->id)->avg('ratings');
        $apps = Apps::with(['categories','ratings'])->where('developer_id', Auth::user()->id)->first();
        $no = 1;
        foreach($ratings as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'ratings' => $ratings,
            'avgrating' => $avgrating,
            'ratingsall' => $ratingsall,
            'apps'=> $apps,
        );
        return view('developer-feedbacks/index')->with('data', $data);
    }
    public function RatingInit($id)
    {
        $ratings = Ratings::with(['endusers','apps'])->where('apps_id',$id)->get();
        $ratingsall = Ratings::with(['endusers','apps'])->get();
        $avgrating = Ratings::where('apps_id',$id)->avg('ratings');
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $no = 1;
        foreach($ratings as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'ratings' => $ratings,
            'avgrating' => $avgrating,
            'ratingsall' => $ratingsall,
            'apps'=> $apps,
        );
        return view('apps-developer/reviewinfo')->with('data', $data);
    }
    public function ReplyFeedbacks(Request $request)
    {
          $updated = Ratings::where('id', $request->id)
            ->update([
                  'reply' => $request->reply,
                  'reply_at' => date('Y-m-d H:i:s'),
                ]
              );
          if ($updated==1) {
              return redirect('feedbacks-and-reply')->with('succ_message', 'Reply telah diperbarui!');

          }else {
              return redirect()->back()->with('err_message', 'Reply gagal diperbarui!');
          }

    }

}
