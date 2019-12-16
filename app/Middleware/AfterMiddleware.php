<?php
/**
 * @author donknap
 * @date 18-11-6 上午9:57
 */

namespace W7\App\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use W7\Core\Middleware\MiddlewareAbstract;

class AfterMiddleware extends MiddlewareAbstract {


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $response =  $handler->handle($request);
        //todo 后置
       // idd($response);
        return $response;
    }
}