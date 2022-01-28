<?php

namespace App\Models;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Message extends Model 
{
    const CREATED_AT = 'received_at';
    const UPDATED_AT = null;
    
    protected $casts = [
        'sent_at'     => 'immutable_datetime:Y-m-d H:i:s',
        'returned_at' => 'immutable_datetime:Y-m-d H:i:s',
        'received_at' => 'immutable_datetime:Y-m-d H:i:s',
    ];
    
    protected $visible = [
        'status',
        'transaction_id',
        'contents',
        'format',
        'received_at',
        'sent_at',
        'returned_at',
        'result'
    ];
    
    protected $appends = [
        'status'
    ];  
    
    
    public function scopeToSend($query)
    {
        return $query->whereNull('sent_at');
    }
    
    public function scopeToReturn($query)
    {
        return $query
        ->has('result')
        ->whereNull('returned_at');
    }
    
    public function result()
    {
        return $this->hasOne(Result::class, 'message_transaction_id', 'transaction_id');
    }
    
    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class, 'key_id');
    }
    
    public function getStatusAttribute()
    {
        if($this->returned())
        {
            return 'returned';
        }
        
        if($this->resultReceived())
        {
            return 'resolved';
        }
        
        if($this->sent())
        {
            return 'sent';
        }
        
        return 'received';
        
        // might need to add 'failed' or other status
    }
    
    public static function findUsingIdentifier($transaction_id = null )
    {
        return static::where(compact('transaction_id'))
            ->with(['result'])
            ->first();
    }
    
    /**
        step 1.a store request
    */
    public static function receive(Request $request )
    {
        $message = new static;
        
        $message->setTransactionId();
        $message->setApiKeyId($request);
        
        $message->contents = $request->input('data.message.contents');
        $message->format   = $request->input('data.message.format');
        $message->payload = $request->getContent();
        
        if($message->save())
        {
            $message->send();
            
            return $message->refresh();
        }
        
        return null;
    }
    
    /**
        step 1.b return reply
    */
    public function toArray()
    {
        // if not stored on database return empty array
        if(!$this->exists)
        {
            return [];
        }
        
        return parent::toArray();
    }
    
    /**
        step 2 send request to blockchain
        
        NOTE: More information about how to make the
        call to the blockchain node is found on /config/node.php
    */
    public function send()
    {
        $options = [
            RequestOptions::JSON    => $this->preparePayloadTosend(),
            RequestOptions::HEADERS => config('node.headers')
        ];
        
        # save payload and timestamp of what we send to blockchain
        $this->sent_payload =json_encode($options);
        $this->sent_at = \Carbon\Carbon::now();
        $this->save();
        
        $response = $this->makeHttpRequest(
            'POST',
            config('node.url'), // this might a boolean false if set as such on .env file for local testing purposes
            $options
        );

        if($result = Result::fromImmediateResponse($response))
        {
            $this->result()->save($result);
        }
        
        return $this->save();
    }
    
    public function sent()
    {
        return !is_null($this->sent_at);
    }

    /**
        step 4 receive result
    */
    public function storeResult(Request $request)
    {
        if($result = Result::receive($request))
        {
            $this->result()->save($result);
            
            return $this->save();
        }
        
        return false;
    }
    
    public function resultReceived()
    {
        return !is_null($this->result);
    }

    /**
        step 5 return result
    */
    public function returnResult()
    {
        // temporatry
        $response = $this->makeHttpRequest(
            'POST',
            'returns',
            ['message' => $this]
        );
        
        if($response)
        {
            $this->return_payload = json_encode($response);
            $this->returned_at = \Carbon\Carbon::now();
            
            return $this->save();
        }
        
        return false;
    }
    
    public function returned()
    {
        return !is_null($this->returned_at);
    }
    
    public function resultSuccessful()
    {
        return $this->result->isSuccessful();
    }
    
    private function setApiKeyId($request)
    {
        /*
            we assume Apikey from request does exists
            because global auth middleware checks
        */
        
        $apiKey = ApiKey::findFromRequest($request);
        
        $this->apiKey()->associate($apiKey);
    }
    
    private function setTransactionId()
    {
        $this->transaction_id = \Illuminate\Support\Str::uuid()->toString();
    }
    
    private function makeHttpRequest($method, $uri, $options)
    {
        $client = $this->getClient($method, $uri, $options);
        
        $uri = $uri ?: 'http://localhost';
        
        //dd($method, $uri, json_encode($options['json']));
        
        return $client->request($method, $uri, $options);
    }
    
    private function preparePayloadTosend()
    {
        /*
            get the formatted data from config as an object
            so we get the right formmated json string
        */
        $payload = (object)config('node.data');
        
        /*
            (!) Note use bin2hex() and prefix with 0x !!
        */
        $contents = "0x" . ($this->format == 'hex' ? $this->contents : bin2hex($this->contents));
        
        # Add the contents to the data we're about to send
        $payload->params[0]['data'] = $contents;
        
        return $payload;
    }
    
    private function getClient($method, $uri, $options)
    {
        if( $uri )
        {
            return new Client();
        }
        
        /*
            URI for sending the Request to blockchain can be set as a boolean false on .env file for local testing purposes
            
            if local testing, lets mock the request
        */
        $headers = ['Content-Type' => 'application/json'];
        $body = collect([
            '{"jsonrpc":"2.0","id":1,"result":"0x1556dcc69a707e178f5f631378497f35de9c331ffeb4a254bee367e86333756e"}',
            '{"jsonrpc":"2.0","id":1,"error":{"code":-32000,"message":"authentication needed: password or unlock"}}'
        ])
        ->random(); //so we test both success and fail
        
        $response = new \GuzzleHttp\Psr7\Response(200, $headers , $body);
        
        $mock = new \GuzzleHttp\Handler\MockHandler([$response]);
        
        $handlerStack = \GuzzleHttp\HandlerStack::create($mock);
        
        return new Client(['handler' => $handlerStack]);
    }
}
