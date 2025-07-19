<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustProxies
{
    protected $proxies = '*';
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}