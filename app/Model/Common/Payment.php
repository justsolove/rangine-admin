<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Payment extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'payment';
   // 主键设置
    protected $primaryKey  = 'payment_id';
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
//    protected $timestamps    = false;

//    protected $hidden = [
//        'router',
//        'help_id',
//        'ver',
//        'module',
//    ];

    /**
     * 获取支付配置列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getPaymentList($data)
    {
        // 查询条件
        $map = [];
        is_client_admin() ?: $map[] = ['status','=', 1];

        if (!is_empty_parm($data['type'])) {
            switch ($data['type']) {
                case 'deposit':
                    $map[] = ['is_deposit','=', 1];
                    break;
                case 'inpour':
                    $map[] = ['is_inpour','=', 1];
                    break;
                case 'payment':
                    $map[] = ['is_payment','=', 1];
                    break;
                case 'refund':
                    $map[] = ['is_refund','=', 1];
                    break;
            }
        }
        $query = idb()->table('payment');
        if (!empty($data['is_select'])) {
            $query = $query->select(['name','code','image']);
            $map[] = ['status','=', 1];
        }
        $query = $query->where($map);
        if(!empty($data['exclude_code']) ){
            $query = $query->whereNotIn('code',$data['exclude_code']);
        }
        return $query->orderBy('sort') ->orderBy('payment_id')->get()->toArray() ?: [];

    }




}