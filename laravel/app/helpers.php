<?php

use App\Models\User;
use App\Models\Device;
use App\Models\AppSetting;
use App\Mail\TestEmail;
use Intervention\Image\ImageManagerStatic as Image;
use Ladumor\OneSignal\OneSignal;
// use Mail;

    function startQueryLog()
    {
        \DB::enableQueryLog();
    }

    function showQueries()
    {
        dd(\DB::getQueryLog());
    }

    function sendMail($mailtemplate,$data, $subject){
        //print_r($data);echo env('MAIL_FROM_ADDRESS');die('dsfds');
        Mail::send($mailtemplate, ['data'=>$data], function ($message) use ($subject, $data) {
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->to($data['email'], env('APP_NAME', 'I Am Alive'))->subject($subject);
        });
        return true;
    }

    
    function chkAuthToken($token) {
      
       $chkToken = AppSetting::whereRaw("auth_token='".$token."'")->count();
        if($chkToken > 0){    
            return $chkToken;

        } else{
           return false;
        }    
      
    }

    function showUserDetails($id)
    {
        $base_path = asset('public/uploads/profile_picture/').'/'; 
        $row = User::leftJoin('user_devices', function($join) {
                  $join->on('users.id', '=', 'user_devices.user_id');
        })
        ->where('users.id',$id)
        ->select('users.id',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.phone_number',
            \DB::raw('IF(profile_image IS NULL, "", CONCAT("'.$base_path.'", profile_image))  AS profile_image'),
            'users.lat',
            'users.lng',
            'users.street_name',
            'users.apartment',
            'users.state',
            'users.city',
            'users.zipcode',
            'users.is_online',
            'users.notification_setting',
            'users.status',
        )->first();
        return $row;
    }

    function doUpload($file,$path,$thumb=false,$pre=null,$id=null) {
     
        $response = [];
        $image = $file;
        if($id!=null){
            $file = $id.'.'.$image->getClientOriginalExtension();
        }else{
            $file = $pre.time().rand().'.'.$image->getClientOriginalExtension();
        }
        $destinationPath = public_path().'/'.$path; 
        Image::make($image)->save($destinationPath.$file);
        $thumbPath = '';
        if($thumb==true){
            $thumbPath = public_path($path).'thumb/'.$file;
            if(!file_exists(public_path($path).'thumb/')) {
              mkdir(public_path($path).'thumb/', 0777, true);
            }
            $cropInfo = Image::make($image)->heighten(200)->save($thumbPath);
        }
        $response['status']     = true;
        $response['file']       = $file;
        $response['thumb']       = $file;
        $response['file_name']  = $file;
        $response['path']       = $path; 
        // print_r($response);die;
        return $response;
      
    }


    