<?php

    namespace App\Http\Middleware;

    use Closure;
    use Auth;

    class CheckAdmin
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            if(Auth::user()->admin) {
                return $next($request);
            } // if(Auth::user()->admin) { ... }

            return redirect()->route('home');
        }
    }
