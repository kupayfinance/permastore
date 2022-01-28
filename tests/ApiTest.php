<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use \App\Models\Message;
use \App\Models\Account;
use \App\Models\ApiKey;


class Api extends TestCase
{
    //use DatabaseMigrations;
    
    public function testReceived()
    {
        
        $account = new Account;
        
        $account->name = 'Timesheetr';
        
        $account->save();
        
        # create key
        $apiKey = new ApiKey;
        
        $apiKey->account_id = $account->getKey();
        $apiKey->name = 'Key ' . \Illuminate\Support\Str::random(4);
        $apiKey->key = \Illuminate\Support\Str::random(64);
        $apiKey->expires_at = \Carbon\Carbon::now()->addYear();
        
        $apiKey->save();
        
        $message = [
            'contents' => 'This contents should be stored',
            'format'   => 'plaintext'
        ];
        
        $data = compact('message');
        
        # call API to store new message 
        $this->post('api/v1/messages/create', compact('data'), ['Authorization' => $apiKey->key])
        
        # assert correct format
        ->seeJsonStructure([
            'status',
            'status_text',
            'data' => [
                'message' => [
                    'transaction_id',
                    'contents',
                    'result',
                    'received_at'
                ]
            ]
        ])
        
        # assert stored contents
        ->seeJson($message + ['status_text' => 'Message stored and resolved']);
    }
    
/*
    Current functionality does require to send message to Blockchain separately
    public function testSent()
    {
        $message = Message::toSend()->first();
        
        # run command to send request to our blockchain node
        $this->artisan('messages:send', [
            '--contents' => [$message->contents]
        ]);
        
        # refresh model then assert sent() returns true
        $this->assertTrue($message->refresh()->sent());
    }
*/
    
/*
    Current API functionality does not require to receive results back separately from Blockchain
    public function testReceivingResults()
    {
        /*
            assuming there will alway be one while testing,
            
            grab the first request that has been sent but doesn't have
            results
        /
        
        $requestModel = Request::doesntHave('result')->whereNotNull('sent_at')->first();
        
        $data = [
            'result' => [ 'transaction_id' => \Illuminate\Support\Str::random(64)],
            'request' => $requestModel->toArray()
        ];
        
        # call API to store result
        $this->post('api/request/result', compact('data'))
        
        # assert response structure
        ->seeJsonStructure([
            'status',
            'message',
            'data' => [
                'request' => [
                    'transaction_id',
                    'contents',
                    'received_at',
                    'sent_at',
                    
                    # result are expected to have data
                    'result' => [
                        'transaction_id',
                        'received_at'
                    ]
                ]
            ]
        ])
        
        # assert success
        ->seeJson(['message' => 'Success']);
    }
*/
    
/*
    Current API functionality does not require to receive results back separately from Blockchain
    public function testResultsRequestNotFound()
    {
        $data = [
            'result' => ['transaction_id' => \Illuminate\Support\Str::random(64)],
            'request' => ['transaction_id' => 'doesNotExists']
        ];
        
        try{
            # call API to store result for non-existant request
            $response = $this->call('POST', 'api/request/result', compact('data'));
        }catch(\Exception $e)
        {
            // keep going
        }
        
        # assert 404 response code
        $this->assertEquals(404, $response->status());
    }
*/
    
/*
    Currently functionality does not require the API to return message results back to the requester
    public function testResultsReturn()
    {
        $requestModel = Request::toReturn()->first();
        
        # run command to send the same request to our blockchain node
        $this->artisan('requests:return', [
            '--contents' => [$requestModel->contents]
        ]);
        
        # refresh model then assert sent() returns true
        $this->assertTrue($requestModel->refresh()->returned());
    } 
*/
}
