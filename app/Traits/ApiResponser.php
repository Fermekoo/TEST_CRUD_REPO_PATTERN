<?php

namespace App\Traits;

trait ApiResponser
{
    protected function trueResponse($message='', $code=200, $data = null){
        
        if($data !== null){
            return response()->json(['code' => $code, 'description' => $message, 'results' => $data],$code);
        }else{
            return response()->json(['code' => $code, 'description' => $message],$code);
        }
    }

    protected function validatorMessage($validator)
    {
            $data = array();
            foreach($validator->messages()->getMessages() as $field_name => $values){
                $data[$field_name]=$values[0];
            }
            
            // $msg = implode(', ',$data);
            $res = [
                'msg'   => reset($data),
                'data'  => $data
            ];
            return $res;
    }
}