<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class cekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
      if (Session::get('currentUser') == null) abort('403');
      if ($role == "mahasiswa") {
        if (Session::get('currentUser')->role == "mahasiswa") {
          return $next($request);
        }
      }
      else if ($role == "dosen") {
        if (Session::get('currentUser')->role == "dosen") {
          return $next($request);
        }
      }
      abort('403');
    }
}
