<?php

namespace App\Models;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface as PsrResponse;

class Result extends Model 
{
    const CREATED_AT = 'received_at';
    const UPDATED_AT = null;
    
    protected $casts = [
        'received_at' => 'immutable_datetime:Y-m-d H:i:s',
    ];
    
    protected $visible = [
        'transaction_id',
        'received_at',
    ];
    
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_transaction_id', 'transaction_id');
    }
    
    public static function receive(Request $request)
    {
        $result = new static;
        
        $result->payload = $request->getContent();
        $result->transaction_id = $request->input('data.result.transaction_id');
        
        if($result->save())
        {
            return $result;
        }
        return null;
    }
    
    public static function fromImmediateResponse(PsrResponse $response)
    {
        $result = new static;
        
        $payload = (string)$response->getBody();
        
        $result->payload = $payload;
        
        $response = collect(json_decode($payload, true));
        
        $result->transaction_id = $response->get('result');
        
        if($result->save())
        {
            return $result;
        }
        return null;
    }
    
    public function isSuccessful()
    {
        return (bool) $this->transaction_id;
    }
    
    public function toArray()
    {
        // if not stored on database return empty array
        if(!$this->exists)
        {
            return [];
        }
        
        return parent::toArray();
    }

}
