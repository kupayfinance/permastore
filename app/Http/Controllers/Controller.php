<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

use App\Models\Account;
use App\Models\ApiKey;

class Controller extends BaseController
{
    public function home(Request $request)
    {
        return view('index');
    }

    public function playgroundReact(Request $request)
    {
        /*
            Let's create new API key per page load
        */
        if(! $apiKey = ApiKey::createForPlayground() )
        {
            abort(500);
        }
        
        return view('playground', compact('apiKey'));
    }

}
