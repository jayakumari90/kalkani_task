<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Models\User;
use App\Models\UserAddress;
class UserController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public $response = ['status' => false, 'message' => "", 'data' => null];
    public $status_code = 200;
    public $user = '';

    public function getUserData(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'email' => 'email',
            ]);
            if ($validator->fails()) {
                $this->response['message'] = $validator->errors()->first();
                // return response()->json($this->response, $this->status_code);
                return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
            }
            else {
                    if(!empty($request->first_name)){

                    }
                    $data = User::with('getUserAddress');

                    if(!empty($request->first_name)){
                        $data->where('first_name', 'LIKE', '%'.$request->first_name.'%');
                    }
                    if(!empty($request->last_name)){ 
                      $data->where('last_name', 'LIKE', '%'.$request->last_name.'%');
                    }
                    if(!empty($request->email)){ 
                      $data->where('email', '=', $request->email);
                    }
                      $data=$data->orderBy('id','Desc')->paginate(50);
                    return response()->json(['status' => true, 'message' => ' ', 'data'=>$data]);
                }
            
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    

    
    
}

