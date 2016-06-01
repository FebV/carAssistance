<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-26
 * Time: 下午11:32
 */
namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckLoginMiddleware
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
        if(!Auth::user())
            return response()->json(['code' => 3, 'status' => 'api_token校验失败', 'result' => '']);

        return $next($request);
    }
}
