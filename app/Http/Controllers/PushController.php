<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Push;
//use Auth;

class PushController extends Controller
{
    public function save(Request $request)
    {
        $user = \Auth::user();       

        if ($push_record = Push::where('user_id',$user->id)->get()->first())
            $push_record->delete();

        $push = new Push([
            'user_id'=>$user->id,
            'object'=> $request->get('object')
        ]);
        

        echo $thejson =  ($push->save()) ? json_encode(['success'=>true,  'data'=>$request]) : json_encode(['success'=>false,  'data'=>$request]);
        self::send($user->id, 'Success! You will now receive notifications');
    }

    public function update()
    {

    }

    public static function send($customer_id, $message)
    {   
        // $repository = new PushRepository;
        
        if ($push = Push::where('user_id',$customer_id)->get()->first())
        {            
            if ($subcriptionArray = json_decode($push->object, true)) // returns assoc array
            {
                $endpoint = $subcriptionArray['endpoint'];
                $keys = $subcriptionArray['keys'];
            } 
        }
        if (isset($subcriptionArray['endpoint']) && isset($subcriptionArray['keys']))
        {
            $ch = curl_init('https://web-push-codelab.glitch.me//api/send-push-msg');

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

            $publicKey = 'BBqP8SNiEPK2acUC4DUB_Mm3Y0ZvVaaPP0qtfGoznSAwaeZjjlXbuXbDMyy6bkmKglbnYE1PYZ8X0F4JVHpzV2s';
            $privateKey = 'nr-jNuCgvkWiFx4yTnlyf_nIwsMXiXQ-SPnv2BHHUs0';
            $applicationKeys = array('public'=>$publicKey,'private'=>$privateKey);

            $dataString = $message;
                
            $subscriptionObject  = array(
                "endpoint"=>$endpoint, 
                "expirationTime"=>null, 
                "keys"=>$keys
            );
            $array = array(
                'subscription'=>$subscriptionObject,
                'data'=>$dataString,
                'applicationKeys'=>$applicationKeys
            );
            $datajson = json_encode($array, JSON_FORCE_OBJECT);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datajson);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($datajson)));
            $result = curl_exec($ch);
            if (!empty($result) && $json = json_decode($result, true))
            {
                if ($json['success'] == true)
                {
                    //echo 'success!';
                }
            }
            else
            {
                $err = curl_error($ch);
                //echo 'Error!: '.$err;
                
            }
             
        }
    }
}
