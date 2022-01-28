<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Contracts\Console\Kernel as Artisan;

use \App\Models\Message;
use \App\Models\TokenPrice;

class MessagesController extends ApiController
{
    private $validation_rules = [
        'store' => [
            'rules' => [
                'data.message.contents' => 'required|max:64',
                'data.message.format'   => 'required|in:plaintext,hex'
            ],
            'messages'  => [
                'data.message.contents.required' => 'Contents are required.',
                'data.message.contents.max' => 'Contents should not exceed 64 characters',
                
                'data.message.format.required' => "Content format ('plaintext' or 'hex') is required.",
                'data.message.format.in' => "Content format ('plaintext' or 'hex') is invalid.",
            ]
        ]
    ];
    
    
    public function store(Request $request)
    {
        $this->validate($request,
            $this->validation_rules['store']['rules'],
            $this->validation_rules['store']['messages']
        );
        
        if( $message = Message::receive($request) )
        {
            if($message->resultSuccessful())
            {
                return $this->respondOk('Message stored and resolved', compact('message'));
            }
            
            return  $this->respondError('Error sending to blockchain', 503, compact('message'));
        }
        
        return $this->respondError('Could not store Message', 500);
    }
    
    public function storeResult(Request $request)
    {
        $this->validate($request, [
            'data.message.transaction_id' => 'required',
            'data.message.transaction_id' => 'required',
        ]);
        
        $identifer = $request->input('data.message.transaction_id');
        
        if(! $message = Message::findUsingIdentifier($identifer) )
        {
            return $this->respondError('Not Found', 404);
        }
        
        if($message->storeResult($request))
        {
            return $this->respondOk('Success', compact('message'));
        }
        
        return $this->respondError('Internal Error', 500);
    }
    
    public function status(Request $request, $transaction_id)
    {
        if(! $message = Request::findUsingIdentifier($transaction_id) )
        {
            return $this->respondError('Not Found', 404);
        }
        
        return $this->respondOk('Success', compact('message'));
    }
    
    public function list(Request $request, $key_id = null)
    {
        $query = Message::with('result');
        
        if($key_id)
        {
            $query->where(compact('key_id'));
        }
        
        $messages = $query->get()->all();
        
        return $this->respondOk('Success', $messages);
    }
    
    public function send(Request $request, $transaction_id = null)
    {
        $options = [];
        $message = null;
        
        if($transaction_id)
        {
            $options = ['--transaction' => [$transaction_id]];
            
            if(! $message = Message::findUsingIdentifier($transaction_id) )
            {
                return $this->respondError('Not Found', 404);
            }
        }
        
        app(Artisan::class)->call('messages:send', $options);
        
        $data = $message ? ['message' => $message->refresh()->toArray()] : [];
        
        return $this->respondOk('Success', $data);
    }
    
    public function returnResult(Request $request, $transaction_id = null)
    {
        $options = [];
        $message = null;
        
        if($transaction_id)
        {
            $options = ['--transaction' => [$transaction_id]];
            
            if(! $message = Message::findUsingIdentifier($transaction_id) )
            {
                return $this->respondError('Not Found', 404);
            }
        }
        
        app(Artisan::class)->call('messages:return', $options);
        
        $data = $message ? ['message' => $message->refresh()->toArray()] : [];
        
        return $this->respondOk('Success', $data);
    }

}
