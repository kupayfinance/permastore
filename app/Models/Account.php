<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model 
{
    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }
    
    public function messages()
    {
        return $this->hasManyThrough(Message::class, ApiKey::class, 'account_id', 'key_id');
    }

}
