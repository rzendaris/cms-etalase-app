<?php

namespace App\Http\Controllers\DevInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Model\Table\Ratings;
use App\Model\Table\Notifikasi;
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

    public function FeedbacksInit(Request $request)
    {
        $paginate = 15;
        // all filter
        if (isset($request->query()['search'], $request->query()['apps'],$request->query()['ratings'])){
            $search = $request->query()['search'];
            $apps = $request->query()['apps'];
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('apps_id',$apps)->where('ratings',$rate)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['search'], $request->query()['apps'])){ // filter search and apps
            $search = $request->query()['search'];
            $apps = $request->query()['apps'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('apps_id',$apps)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['search'], $request->query()['ratings'])){ // filter search and ratings
            $search = $request->query()['search'];
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('ratings',$rate)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['apps'], $request->query()['ratings'])){ // filter apps and ratings
            $apps = $request->query()['apps'];
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('ratings',$rate)->where('apps_id',$apps)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['apps' => $apps]);
        }else if (isset($request->query()['search'])){ // filter search
            $search = $request->query()['search'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['apps'])){ // filter apps
            $apps = $request->query()['apps'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('apps_id',$apps)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['apps' => $apps]);
        }else if (isset($request->query()['ratings'])){ // filter ratings
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('ratings',$rate)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['rate' => $rate]);
        } else {
          $ratings = Ratings::with(['endusers','apps'])->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
        }
        $ratingsall = Ratings::with(['endusers','apps'])->get();
        $avgrating = Ratings::where('users_dev_id',Auth::user()->id)->avg('ratings');
        $apps = Apps::where('developer_id', Auth::user()->id)->get();
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
    public function RatingInit($id,Request $request)
    {
        $paginate = 15;
        if (isset($request->query()['search'], $request->query()['ratings'])){ // filter search and ratings
            $search = $request->query()['search'];
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('ratings',$rate)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['search'])){
            $search = $request->query()['search'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('users.email', 'like', "%" . $search. "%")->where('apps_id',$id)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
            $ratings->appends(['search' => $search]);
        }else if (isset($request->query()['ratings'])){ // filter ratings
            $rate = $request->query()['ratings'];
            $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('ratings',$rate)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
        }else {
          $ratings = Ratings::join('users','ratings.end_users_id','users.id')->where('apps_id',$id)->where('users_dev_id',Auth::user()->id)->orderBy('comment_at', 'asc')->simplePaginate($paginate);
        }
        $ratingsall = Ratings::with(['endusers','apps'])->get();
        $avgrating = Ratings::where('apps_id',$id)->avg('ratings');
        $apps = Apps::with(['categories','ratings'])->where('id', $id)->first();
        $no = 1;
        foreach($ratings as $data){
            $data->no = $no;
            $no++;
        }
        $data = array(
            'id' => $id,
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
          $created = Notifikasi::create([
              'to_users_id' => $request->to_users_id,
              'from_users_id' => Auth::user()->id,
              'content' => $request->apps_name." di Reply oleh",
              'apps_id' => $request->apps,
              // 'token' => Str::random(60),
          ]);
          if ($updated==1) {
              return redirect('feedbacks-and-reply')->with('succ_message', 'Reply telah diperbarui!');

          }else {
              return redirect()->back()->with('err_message', 'Reply gagal diperbarui!');
          }
    }
    public function NotifRead()
    {
      if(isset($_GET['view'])){

      // $con = mysqli_connect("localhost", "root", "", "notif");

      if($_GET["view"] != '')
      {
            $updated = Notifikasi::where('to_users_id', Auth::user()->id)->update([
                  'read_at' => date('Y-m-d H:i:s')
                ]);
              }
            $ratings = Notifikasi::where('to_users_id',Auth::user()->id)->orderBy('created_at', 'desc')->limit( 5 )->get();
            $output = '';
            if(count($ratings) > 0)
            {
              foreach ($ratings as $row) {
                  $output .= '
                  <li class="list-group-item">
                      '.$row->content.'<br>
                      <small><i class="fa fa-clock-o"></i> '.$row->created_at.'</small>
                  </li>';
             }
            }
            else{
                 $output .= '
                 <li><a href="#" class="text-bold text-italic">Notification Not Found</a></li>';
            }
            $output .='<div class="card text-center">
                  <a href="#" style="padding: 20px;display:block;" id="load-more-btn" onmouseover="loadmorebutton()">More</a>
              </div>';
            $notify = Notifikasi::with(['fromusers','apps'])->where('to_users_id',Auth::user()->id)->where('read_at',NULL)->get();
            $count = count($notify);
            $data = array(
                'notification' => $output,
                'unseen_notification'  => $count
            );
            echo json_encode($data);
          }
    }
    public function NotifReadAll()
    {
      if(isset($_GET['view'])){

      if($_GET["view"] != '')
      {
            $updated = Notifikasi::where('to_users_id', Auth::user()->id)->update([
                  'read_at' => date('Y-m-d H:i:s')
                ]);
              }
            $ratings = Notifikasi::where('to_users_id',Auth::user()->id)->orderBy('created_at', 'desc')->limit( 20 )->get();
            $output = '';
            foreach ($ratings as $row) {
                $output .= '
                <li class="list-group-item">
                    '.$row->content.'<br>
                    <small><i class="fa fa-clock-o"></i> '.$row->created_at.'</small>
                </li>';
            }
            $notify = Notifikasi::with(['fromusers','apps'])->where('to_users_id',Auth::user()->id)->where('read_at',NULL)->get();
            $count = count($notify);
            $data = array(
                'notification' => $output,
                'unseen_notification'  => $count
            );
            echo json_encode($data);
          }
    }
}
