<?php

namespace App\Http\Controllers;

use App\Friendship;
use App\Notification;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
   	public function index($slug){
   		return view('profile/index')->with('data', Auth::user()->profile);
   	}

   	#upload profile image
   	public function uploadImage(Request $request){
   		$file = $request->file('pic');
   		$filename = $file->getClientOriginalName();

   		$path = 'img';

   		$file->move($path, $filename);

   		$user_id = Auth::user()->id;
   		DB::table('users')->where('id',$user_id)->update(['pic'=>$filename]);

   		return redirect('profile/index');
   	}


      #update profile 
      public function updateProfile(Request $request){
         $user_id = Auth::user()->id;
         Profile::where('user_id',$user_id)->update($request->except('_token'));
         Session::flash('message', 'Profile updated success !');
         return back();
      }

      #find friends
      public function findFriends(){
         $uid = Auth::user()->id;
         $allUsers = User::where('id', '!=', $uid)->with('profile')->get();
         return view('profile.findFriend', compact('allUsers'));
      }

      #send friends request
      public function sendFriend($id){
         Auth::user()->addFriend($id);
         return back();
      }

      #see friends requests view
      public function requests(){
         $uid = Auth::user()->id;
         $friendRequests = Friendship::rightJoin('users', 'users.id', '=', 'friendships.requester')
                           ->where('friendships.user_requested', '=', $uid)
                           ->where('status', 0)
                           ->get();
         return view('profile.request', compact('friendRequests'));

      }

      #accept friends requests
      public function accept($name, $id){
         $uid = Auth::user()->id;
         $acceptFriends = Friendship::where('requester', $id)
                        ->where('user_requested', $uid)
                        ->first();
         if ($acceptFriends) {
            $update = Friendship::where('requester',$id)
                                 ->where('user_requested',$uid)
                                 ->update(['status' => 1]);

            #notifications table 
            $notification = new Notification;
            $notification->note = 'Accepted your friend request';
            $notification->user_hero = Auth::user()->id;
            $notification->user_logged = $id;
            $notification->status = 1;
            $notification->save();

            if($update){
               return back()->with('msg','You are new friend with '. $name);
            }                     
         } else {
            return 'wrong';
         }
         
         

      }

      #friends 
      public function friends(){

         $uid = Auth::user()->id;

         $friends1 = DB::table('friendships')
                        ->where('status', 1)
                        ->leftJoin('users', 'users.id', 'friendships.user_requested')
                        ->where('requester', $uid)
                        ->get();

          $friends2 = DB::table('friendships')
                        ->where('status', 1)
                        ->leftJoin('users', 'users.id', 'friendships.requester')
                        ->where('user_requested', $uid)
                        ->get();   


         $friends = array_merge($friends1->toArray(),$friends2->toArray());


         return view('profile.friend', compact('friends'));

      }

      public function removeAccept($id){
         $uid = Auth::user()->id;

         $remove = DB::table('friendships')
                     ->where('requester', $id)
                     ->where('user_requested',$uid)
                     ->delete();

         return back()->with('msg', 'Cancel this request');            
      }

      public function notifications($id){
         $uid = Auth::user()->id;

         $notes = DB::table('users')
                     ->leftJoin('notifications', 'users.id', 'notifications.user_hero')
                     ->where('notifications.id',$id)
                     ->where('user_logged',Auth::user()->id)
                     ->orderBy('notifications.id','Desc')
                     ->get();

         $updateNoti = Notification::where('user_logged',$uid)
                                 ->where('user_hero',$id)
                                 ->update(['status' => 0]);

         return view('profile.notification',compact('notes'));
      }
}
