<?php
/**
 * @author donknap
 * @date 18-11-6 上午9:57
 */

namespace W7\App\Middleware;

use  W7\App\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use W7\Core\Middleware\MiddlewareAbstract;
use W7\App\Model\Common\Setting;
use W7\App\Model\Service\Config;

class BaseMiddleware extends MiddlewareAbstract {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        // 获取全局配置
       $setting = Setting::get()->toArray();
        foreach ($setting as $value) {
            Config::set($value['code'], $value, $value['module']);
        }
        // 转化post参数
        $request->post = json_decode($request->raw(),1);
		return $handler->handle($request);
	}

}