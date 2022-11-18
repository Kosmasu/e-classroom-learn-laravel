<?php

namespace App\Http\Middleware;

use App\Models\Logging as ModelsLogging;
use Closure;
use Illuminate\Http\Request;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      $response = $next($request);
      ModelsLogging::create([
        "log_route_path" => $request->fullUrl(),
        "log_ip_address" => $request->ip(),
        "log_status_code" => $response->getStatusCode(),
      ]);
      return $response;
    }
}
