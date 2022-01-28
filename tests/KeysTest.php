<?php


use \App\Models\Message;
use \App\Models\ApiKey;
use \App\Models\Account;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class KeysTest extends TestCase
{
    //use DatabaseMigrations;
    
    public function testUnauthorized()
    {
        $message = [
            'contents' => \Illuminate\Support\Str::random(32),
            'format'   => 'plaintext'
        ];
        
        $data = compact('message');
        
        # call API to store new message 
        $this->post('api/v1/messages/create', compact('data'));
        
        $this->assertEquals(401, $this->response->status());
    }
    
    public function testAuthorized()
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
            'contents' => \Illuminate\Support\Str::random(32),
            'format'   => 'plaintext'
        ];
        
        $data = compact('message');
        
        # call API to store new message 
        $this->post('api/v1/messages/create', compact('data'), ['Authorization' => $apiKey->key]);
        
        $this->assertTrue(in_array($this->response->status(), [200,503]));
    }
    
    public function testNonExistantKey()
    {
        $message = [
            'contents' => \Illuminate\Support\Str::random(32),
            'format'   => 'plaintext'
        ];
        
        $data = compact('message');
        
        # call API to store new message 
        $this->post('api/v1/message/create', compact('data'), ['Authorization' => 'does-not-exist']);
    
        $this->assertNull(ApiKey::findFromRequest(app('request')));
    }
    
    public function testExpiredKey()
    {
        # create key
        $apiKey = new ApiKey;
        
        $apiKey->account_id = 1;
        $apiKey->name = 'Key ' . \Illuminate\Support\Str::random(4);
        $apiKey->key = \Illuminate\Support\Str::random(64);
        $apiKey->expires_at = \Carbon\Carbon::now()->subDay();
        
        $apiKey->save();
        
        $this->assertTrue($apiKey->isExpired());
    }
}
