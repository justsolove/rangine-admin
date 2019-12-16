<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Token extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'token';

    public $timestamps    = false;

    public $primaryKey  = 'token_id';
    public $incrementing   = true;
    /**
     * 模型的默认属性值。
     *
     * @var array
     */
    protected $hidden = [
        'token_id',
        'client_id',
        'client_type',
        'code',
    ];

    /**
     * 可以被批量赋值的属性。
     *
     * @var array
     */
     protected $fillable = [
         'client_id',
         'group_id',
         'username',
         'client_type',
         'platform',
         'code',
         'token',
         'token_expires',
         'refresh',
         'refresh_expires',
     ];
    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    // protected $guarded = ['price'];

    /**
     * 产生Token
     * @access public
     * @param  int    $id       编号
     * @param  int    $group    用户组编号
     * @param  int    $type     顾客或管理组
     * @param  string $username 账号
     * @param  string $platform 来源平台
     * @return false|array
     * @throws
     */
    public function setToken($id, $group, $type, $username, $platform)
    {
        $code = rand_string();
        $token = user_md5(sprintf('%d%d%s', $id, $type, $code));
        $expires = time()+ (30 * 24 * 60 * 60); // 30天
        // 准备数据
        $params = [
            'client_id'=> $id,
            'client_type'=> $type,
            'platform' => $platform
        ];
        $data = [
            'client_id'       => $id,
            'group_id'        => $group,
            'username'        => $username,
            'client_type'     => $type,
            'platform'        => $platform,
            'code'            => $code,
            'token'           => $token,
            'token_expires'   => $expires,
            'refresh'         => user_md5(rand_string() . $token),
            'refresh_expires' => $expires + 86400,
        ];
        return self::updateOrCreate($params,$data)->toArray();
    }
    /**
     * 刷新Token
     * @access public
     * @param  int    $type     顾客或管理组
     * @param  string $refresh  刷新令牌
     * @param  string $oldToken 原授权令牌
     * @return false|array
     * @throws
     */
    public function refreshUser($type, $refresh, $oldToken)
    {
        // 搜索条件
        $result = self::get()->where('client_id',get_client_id())
            ->where('client_type',$type)
            ->where('token',$oldToken)
            ->first();

        if (!$result) {
            return is_null($result) ? 'refresh不存在' : false;
        }

        if (time() > $result->refresh_expires) {
            return 'refresh已过期';
        }

        if (!hash_equals($result->refresh, $refresh)) {
            return 'refresh错误';
        }

        // 准备更新数据
        $code = rand_string();
        $token = user_md5(sprintf('%d%d%s', get_client_id(), $type, $code));
        $expires = time() + (30 * 86400); // 30天

        $result->code =  $code;
        $result->token =  $token;
        $result->token_expires =  $expires;
        $result->refresh =  user_md5(rand_string() . $token);
        $result->refresh_expires =  $expires + (1 * 24 * 60 * 60);

        if (false !== $result->save()) {
            return $result->toArray();
        }

        return false;
    }

}