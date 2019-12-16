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
use W7\App;

class BeforeMiddleware extends MiddlewareAbstract {

    /**
     * 控制器错误信息
     * @var string
     */
    public $error;

    /**
     * AppKey
     * @var string
     */
    public $appkey;
    /**
     * Token
     * @var string
     */
    public $token;

    /**
     * Sign
     * @var string
     */
    public $sign;

    /**
     * 时间戳
     * @var int
     */
    public $timestamp;

    /**
     * 返回格式
     * @var string
     */
    public $format;

    /**
     * 业务参数
     * @var array
     */
    public $params = [];

    /**
     * 权限验证实例
     * @var object
     */
    protected static $auth;

    /**
     * 是否调试模式
     * @var bool
     */
    public $apiDebug = false;



    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        $this->params = $request->post;
        // 公共参数赋值
        $this->appkey = isset($this->params['appkey']) ? $this->params['appkey'] : '';
        $this->token = isset($this->params['token']) ? $this->params['token'] : '';
        $this->sign = isset($this->params['sign']) ? $this->params['sign'] : '';
        $this->timestamp = isset($this->params['timestamp']) ? $this->params['timestamp'] : 0;

        // 验证Token
        $token = $this->checkToken();
        if (true !== $token) {
            // 未授权，请重新登录(401)
            throw new HttpException($token,401);
        }

		return $handler->handle($request);
	}

    /**
     * 只验证Token是否合法,否则一律按游客处理
     * @access private
     * @return string|true
     */
	public function checkToken(){

        $data = idb()->table('token')->where('token',$this->token)->first();
        // 存在Token则进行验证
        if (!is_null($data)) {
            // 必须先检测Token是否过期,不然下面的检测没意义
            if (empty($data->token_expires) || time() > $data->token_expires) {
                return 'token已过期';
            }
            // 还原Token加密过程
            $token = user_md5(sprintf('%d%d%s', $data->client_id, $data->client_type, $data->code));

            // 取错的情况下第2个比较逻辑成立,否则为非法Token
            if (!hash_equals($token, $this->token) || $token != $data->token) {
                return 'token错误';
            }
            App::getApp()->getContainer()->set('client',[
                'type'        =>  $data->client_type,
                'group_id'    =>  $data->group_id,
                'client_id'   =>  $data->client_id,
                'client_name' =>  $data->username,
            ]);
        } else if (!empty($this->token)) {
            // 不以白名单方式访问一律按Token未授权处理
            return '未授权或授权已过期';
        } else{
            return 'token不存在';
        }
        return true;
    }


}