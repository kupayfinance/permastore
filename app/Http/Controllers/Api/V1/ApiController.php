<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function respondOk($status_text, array $data = [])
    {
        return $this->respond('ok', 200, $status_text, true, $data);
    }
    
    protected function respondError($status_text, $code = 500, array $data = [])
    {
        return $this->respond('error', $code, $status_text, false, $data);
    }
    
    protected function respond($status, $code, $status_text, $success, array $data = [])
    {
        return response()->json(
            compact('status', 'status_text', 'success', 'data'),
            $code
        );
    }
}
