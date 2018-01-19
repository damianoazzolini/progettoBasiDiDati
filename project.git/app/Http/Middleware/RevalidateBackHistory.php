<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RevalidateBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next) {
        $response = $next($request);
        if(! $response instanceof SymfonyResponse) {
            $response = new Response($response);
        }

        $id = Auth::id();

        if($id == null) {
            return redirect()->action('CreateController@index')->with('message','UTENTE NON AUTENTICATO');
        }   

        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        $response->header('Cache-Control', 'no-cache, must-revalidate, no-store, max-age=0, private');

        return $response;
        
    }
    /*
    public function handle($request, Closure $next) {
       
        $response = $next($request);

        if(! $response instanceof SymfonyResponse) {
            $response = new Response($response);
        }

        $id = Auth::id();

        if($id == null) {
            return redirect()->action('CreateController@index')->with('message','UTENTE NON AUTENTICATO');
        }   

        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        $response->header('Cache-Control', 'no-cache, must-revalidate, no-store, max-age=0, private');

        return $response;
    }
    */
}