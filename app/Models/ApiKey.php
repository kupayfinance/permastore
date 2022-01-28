<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiKey extends Model 
{
    protected $casts = [
        'expires_at'     => 'datetime:Y-m-d H:i:s',
    ];
    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class, 'key_id');
    }
    
    public static function findFromRequest(Request $request)
    {
        $key = $request->headers->get(config('api_keys.header'));

        return static::where(compact('key'))->first();
    }
    
    public static function isValid(Request $request)
    {
        if(! $apiKey = static::findFromRequest($request))
        {
            return false;
        }
        
        return ! $apiKey->isExpired();
    }
    
    public static function createForPlayground()
    {
        // hack for local development
        if(!config('node.url'))
        {
            return static::first();
        }
        
        $apiKey = new static;
        
        $apiKey->account_id = 1;
        $apiKey->name = 'Key ' . \Illuminate\Support\Str::random(4);
        $apiKey->key = \Illuminate\Support\Str::random(64);
        $apiKey->expires_at = \Carbon\Carbon::now()->addYear();
        
        if( $apiKey->save() )
        {
            return $apiKey;
        }
        
        return null;
    }
    
    public function isExpired()
    {
        # if expired is null key never expires
        if(!$this->expires_at)
        {
            return false;
        }
        
        return  $this->expires_at->isPast();
    }
}
