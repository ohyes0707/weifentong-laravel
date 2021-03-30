<?php
namespace App\Http\Middleware;

use Closure;

/**
 * 检查运营登陆中间件
 * @author luojia
 *
 */
class CheckOperateLoginMiddleware
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
        $operate_userid = session()->get('operate_userid');
        // 如果有$session['operate_userid'],进入正常控制器
        if(isset($operate_userid)) {
            return $next($request);
        }
        else {
            // 如果取不到运营的session['operate_userid']，跳转到运营登陆页面
            return  redirect('operate/user/login');
        }
    }
}

?>