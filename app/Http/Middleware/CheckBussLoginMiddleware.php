<?php
namespace App\Http\Middleware;

use Closure;

/**
 * 检查运营登陆中间件
 * @author luojia
 *
 */
class CheckBussLoginMiddleware
{

    /**
     * 构造函数
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $buss_id = session()->get('buss_id');
        // 如果有$session['buss_id'],进入正常控制器
        if(isset($buss_id)) {
            return $next($request);
        }
        else {
            // 如果取不到商家的$session['buss_id']，跳转到商家登陆页面
            return  redirect('buss/user/login');
        }
    }
}

?>