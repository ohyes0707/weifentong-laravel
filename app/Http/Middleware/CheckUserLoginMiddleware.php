<?php
namespace App\Http\Middleware;

use Closure;

/**
 * 检查用户登陆中间件
 * @author luojia
 *
 */
class CheckUserLoginMiddleware
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
        $userid = session()->get('userid');
        // 如果有$session['userid'],进入正常控制器
        if(isset($userid)) {
            return $next($request);
        }
        else {
            // 如果取不到用户的session['userid']，跳转到用户登陆页面
            return  redirect('home/user/login');
        }
    }
}

?>