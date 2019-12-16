<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Ask extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'ask';
   // 主键设置
    protected $primaryKey  = 'ask_id';

    public $incrementing   = true;
    public $timestamps    = false;


    /**
     * 主题
     * @var int
     */
    const ASK_TYPT_THEME = 0;

    /**
     * 提问
     * @var int
     */
    const ASK_TYPT_ASK = 1;

    /**
     * 回答
     * @var int
     */
    const ASK_TYPT_ANSWER = 2;

    /**
     * 隐藏属性
     * @var array
     */
    protected $hidden = [
        'parent_id',
        'is_delete',
    ];

    /**
     * 全局查询条件
     * @access protected
     * @param  object $query 模型
     * @return void
     */
    protected function base($query)
    {
        $query->where(['is_delete' => ['eq', 0]]);
    }

    /**
     * hasOne ims_user
     * @access public
     * @return mixed
     */
    public function getUser()
    {
        return $this
            ->hasOne('W7\App\Model\Common\User', 'user_id', 'user_id');

    }

    /**
     * hasMany ims_ask
     * @access public
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany('W7\App\Model\Common\Ask', 'parent_id','ask_id')->orderBy('ask_id','asc');
    }

    /**
     * 获取问答主题列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getAskList($data)
    {
        // 搜索条件
        $map = [
            ['ask.parent_id','=', 0],
            ['ask.type','=', self::ASK_TYPT_THEME],
            ['ask.is_delete','=', 0]
        ];
        is_empty_parm($data['ask_type']) ?: $map[] = ['ask.ask_type','=', $data['ask_type']];
        is_empty_parm($data['status']) ?: $map[] = ['ask.status','=', $data['status']];

        // 关联查询
        $with = [];

        // 后台管理搜索
        if (is_client_admin()) {
            $with = ['getUser:user_id,username,nickname,level_icon,head_pic'];
        }else{
            $map[] = ['ask.user_id','=', get_client_id()];
        }

        $query = $this->with($with)->where($map);
        if(is_client_admin() && !empty($data['account'])){
            $str = $data['account'];
            $query =  $query->orWhereHas ('getUser',function ($serch) use($str){
                $serch->where('username','=',$str);
            });
            $query =  $query->orWhereHas ('getUser',function ($serch) use($str){
                $serch->where('nickname','=',$str);
            });
        }

        $totalResult = $query->count();
        if ($totalResult <= 0) {
            return ['total_result' => 0];
        }

        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 25;
        // 翻页页数
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;
        $pageCur = ($pageNo-1) * $pageSize;

        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        // 排序的字段
        $orderField = 'ask.ask_id';
        if (isset($data['order_field'])) {
            switch ($data['order_field']) {
                case 'ask_id':
                case 'ask_type':
                case 'title':
                case 'status':
                case 'create_time':
                    $orderField = 'ask.' . $data['order_field'];
                    break;

                case 'username':
                case 'nickname':
                    $orderField = 'getUser.' . $data['order_field'];
                    break;
            }
        }
        $result = $query
            ->orderBy($orderField , $orderType)
            ->offset($pageCur)->limit($pageSize)
            ->get()?: [];
        return ['items' => $result, 'total_result' => $totalResult];

    }

    /**
     * 删除一条记录
     * @access public
     * @param  array $data 外部数据
     * @return bool
     * @throws
     */
    public function delAskItem($data)
    {

        $map[] = ['ask_id','=', $data['ask_id']];
        is_client_admin() ?: $map[] = ['user_id','=', get_client_id()];
        $result = $this->where($map)->get()->first();
        if (!$result) {
            return true;
        }

        if ($result->type === self::ASK_TYPT_THEME) {
            $this->orWhere('ask_id','=',$data['ask_id'])->orWhere('parent_id','=',$data['ask_id'])->update(['is_delete' => 1]);
        } else {
            $this->where($map)->update(['is_delete' => 1]);
        }

        return true;
    }

    /**
     * 获取一个问答明细
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getAskItem($data)
    {

        $map[] = ['ask.ask_id','=', $data['ask_id']];
        $map[] = ['ask.is_delete','=', 0];
        is_client_admin() ?: $map[] = ['ask.user_id','=', get_client_id()];

        return $this->with(['getUser:user_id,username,nickname,level_icon,head_pic',
            'getItems:parent_id,user_id,ask_type,ask,answer,title,status' ])
            ->where($map)->get()->first() ?: [];

        // 获取主题与账号信息
        $result = self::useGlobalScope(false)->find(function ($query) use ($data) {
            $map['ask.ask_id'] = ['eq', $data['ask_id']];
            $map['ask.is_delete'] = ['eq', 0];
            is_client_admin() ?: $map['ask.user_id'] = ['eq', get_client_id()];

            $with = ['getUser'];
            $with['getItems'] = function ($query) {
                $query->field('user_id,ask_type,title,status', true)->order('ask_id');
            };

            $query->where($map)->field('ask,answer', true)->with($with);
        });

        if (false !== $result) {
            return is_null($result) ? null : $result->toArray();
        }

        return false;
    }

}