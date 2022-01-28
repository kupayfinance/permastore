<?php

namespace App\Http\Middleware\V1;

use Closure;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class Authenticate
{

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    protected $except = [
        'playground',
        '/',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ( ! $this->routeIsExcluded() && ! $this->apiKeyIsValid()) {
            return response()->json('Unauthorized', 401);
        }
        
        return $next($request);
    }
    
    private function apiKeyIsValid()
    {
        return ApiKey::isValid($this->request);
    }
    
    private function routeIsExcluded()
    {
        return in_array($this->request->path(), $this->except);
    }
}
