<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;
class Notification extends Model
{
    use HasFactory;
    public static function saveNotification($user_id, $type, $title, $message)
    {

        $user = Device::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        foreach ($user as $key => $value) {
        	# code...
	        
	        $value->device_id ? $firebaseToken = $value->device_id : $firebaseToken = 'invalid_token';

	        $type ? $type : $type = array('type'=>'Nothing');

	        $message ? $message:'No Message';
	        
	        $ids = array($firebaseToken);
	        $notification = new Notification();
	        $notification->user_id = $user_id;
	        $notification->title = $title;
	        $notification->message = $message;
	        $notification->notification_date = time();
	        $notification->save();
	        $SERVER_API_KEY = env('FCM_API_KEY');
	        //     die('wwww');       


	        $fields = array(
	            'priority' => "high",
	            'registration_ids' => $ids,
	            'notification' => array("title"=> $title,"body" => $message,"type"=>$type,"click_action" => "FCM_PLUGIN_ACTIVITY"),
	            'data' => array("data" => $notification, 'notification' => array("title"=> $title,"body" => $message,"type"=>$type,"click_action" => "FCM_PLUGIN_ACTIVITY"),"content_available" => 1, "force-start" => 1,"click_action" => "FCM_PLUGIN_ACTIVITY", "sound" => "default"),
	            'delay_while_idle' => false,
	        );

	        $dataString = json_encode($fields);
	        //print_r($dataString);echo "<br>";
	        $headers = array(
	            'Authorization: key=' . $SERVER_API_KEY,
	            'Content-Type: application/json'
	        );

	        $ch = curl_init();
	        
	        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

	        $result = curl_exec($ch);
	        print_r($result);echo "<br>";
	        curl_close($ch);
	    }
    
    }

}
