<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class Message extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'message';
   // 主键设置
    protected $primaryKey  = 'message_id';


    protected $fillable = ['type','member','title','content','url','target','page_views','is_top','status'];
 //   protected $hidden = ['password', 'is_delete'];
//    // 主键是否递增
//    protected $incrementing   = true;
//    // 主键是否 int
//    protected $keyType   = true;
//    // 是否自动管理 created_at 和 updated_at
    public $timestamps    = false;

    public $error = '';
    /**
     * 用户获取未读消息数
     * @access public
     * @param  array $data 外部数据
     * @return false|array
     * @throws
     */
    public function getMessageUserUnread($params)
    {
        if(!isset($params['is_read'])){
            $params['is_read'] = 0;
        }
        $clientId = get_client_id();
        if (is_client_admin()) {
            $member = '= 2';
            $clientType = 'admin_id';
            $createTime = idb()->table('admin')->where('admin_id',$clientId)->value('create_time');
        } else {
            $member = '< 2';
            $clientType = 'user_id';
            $createTime = idb()->table('user')->where('user_id',$clientId)->value('create_time');
        }

        is_empty_parm($params['type']) ?: $map['m.type'] = ['eq', $params['type']];
        // 联合查询语句
        // 构建子语句
        $user = idb()->table('message_user')->where($clientType,$clientId);
        // 联合查询
        $result = idb()->table('message as m')->leftJoinSub($user,'u', function($join){
                $join->on('m.message_id','=','u.message_id');
            })
            ->selectRaw('ims_m.type,COUNT(*) total')
            ->where('m.status','=',1)
            ->where('m.is_delete','=',0)
            ->where('m.create_time','>=',$createTime)
            ->where(function ($query) use($clientId,$clientType) {
                    $query->where('u.'.$clientType, '=',null)
                        ->orWhere('u.'.$clientType, '=',$clientId);
            })
            ->where(function ($query) use($clientId,$clientType) {
                $query->where('u.'.$clientType, '=',null)
                    ->orWhere('u.is_delete', '=',0);
            })
            ->where(function ($query) use($clientId,$clientType) {
                $query->where('u.'.$clientType, '!=',null)
                    ->orWhere('m.member', '=',2);
            })
            ->where(function ($query) use($params,$clientType) {
                if (!is_empty_parm($params['is_read'])) {
                    switch ($params['is_read']) {
                        case 0:
                            $query->where('u.'.$clientType, '=',null)
                                ->orWhere('u.is_read', '=',0);
                            break;
                        case 1:
                            $query->where('u.is_read', '=',1);
                            break;
                    }
                }
            })
            ->groupBy('m.type')->get()->toArray();


        if (false !== $result) {
            $total = array_column($result,'total', 'type');
            $total['total'] = array_sum($total);
            return $total;
        }

        return false;
    }

    /**
     * 用户获取消息列表
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getMessageUserList($data)
    {
        $clientId = get_client_id();
        $clientType = 'admin_id';
        $createTime = Admin::where([[$clientType,'=', $clientId]])->pluck('create_time');
        is_empty_parm($data['type']) ?: $map[] = ['m.type','=', $data['type']];
        $map[] = ['m.status','=', 1];
        $map[] = ['m.is_delete','=', 0];
        $map[] = ['m.create_time','>=', $createTime];
        $mapRead = null;

        // 是否已读需要特殊对待


        // 构建子语句
        //$userSQL = MessageUser::where([$clientType => ['eq', $clientId]])->buildSql();

        // 联合查询语句
//        $userWhere_3 = '`ims_u`.' . $clientType . ' IS NOT NULL OR `ims_m`.member ' . $member;

        $totalResult = idb()->table('message as m')
            ->leftJoin(idb()->raw("(SELECT * FROM `ims_message_user` where ".$clientType."= '".$clientId."' ) as ims_u"),function ($join) {
                $join->on( 'u.message_id', '=', 'm.message_id');
            })
            ->where(function ($query) use($clientId,$clientType) {
                if($clientId){
                    $query->where('u.'.$clientType, '=',null)
                        ->orWhere('u.'.$clientType, '=',$clientId);
                }else{
                    $query->where('u.'.$clientType, '=',null)
                        ->orWhere('u.'.$clientType, '=',1);
                }

            })
            ->where(function ($query) use($clientType) {
                    $query->where('u.'.$clientType, '=',null)
                        ->orWhere('u.is_delete', '=',0);
            })
            ->where(function ($query) use($clientType) {
                $query->where('u.'.$clientType, '!=',null)
                    ->orWhere('m.member', '=',2);
            })
            ->where(function ($query) use($data,$clientType) {
                if (!is_empty_parm($data['is_read'])) {
                    switch ($data['is_read']) {
                        case 0:
                            $query->where('u.'.$clientType, '=',null)
                                ->orWhere('u.is_read', '=',0);
                            break;
                        case 1:
                            $query->where('u.is_read', '=',1);
                            break;
                    }
                }
            })
            ->where($map)
           // ->where($mapRead)
            ->count();
        $message = ['total_result' => $totalResult];
        if (!empty($data['is_unread'])) {
            $unread = $this->getMessageUserUnread($data);
            if (false !== $unread) {
                $message['unread_count'] = $unread;
            }
        }

        if ($totalResult <= 0) {
            return $message;
        }

        // 翻页页数
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;

        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 20;
        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        $page=$pageNo-1;
        if ($page != 0) {
            $startNum = $pageSize * $page;
        }else{
            $startNum =0;
        }
        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'message_id';

        $result = idb()->table('message as m')
            ->selectRaw('ims_m.message_id,ims_m.type,ims_m.title,ims_m.url,ims_m.is_top,ims_m.target,ifnull(ims_u.is_read, 0) is_read,ims_m.create_time')
            ->leftJoin(idb()->raw("(SELECT * FROM `ims_message_user` where ".$clientType."= '".$clientId."' ) as ims_u"),function ($join) {
                $join->on( 'u.message_id', '=', 'm.message_id');
            })
            ->where(function ($query) use($clientId,$clientType) {
                if($clientId){
                    $query->where('u.'.$clientType, '=',null)
                        ->orWhere('u.'.$clientType, '=',$clientId);
                }

            })
            ->where(function ($query) use($clientType) {
                $query->where('u.'.$clientType, '=',null)
                    ->orWhere('u.is_delete', '=',0);
            })
            ->where(function ($query) use($clientType) {
                $query->where('u.'.$clientType, '!=',null)
                    ->orWhere('m.member', '=',2);
            })
            ->where(function ($query) use($data,$clientType) {
                if (!is_empty_parm($data['is_read'])) {
                    switch ($data['is_read']) {
                        case 0:
                            $query->where('u.'.$clientType, '=',null)
                                ->orWhere('u.is_read', '=',0);
                            break;
                        case 1:
                            $query->where('u.is_read', '=',1);
                            break;
                    }
                }
            })
            ->where($map)
            ->orderBy('m.is_top','desc')
            ->orderBy('m.'.$orderField,$orderType)
            ->offset($startNum)
            ->limit($pageSize)
            ->get()->toArray();
        $result = $this->getList($result);
        foreach ($result as $key=>$value){
            if($value['create_time']){
                $result[$key]['create_time'] = date("Y-m-d H:i:s",$value['create_time']);
            }
        }
        if (false !== $result) {
            $message['items'] = $result;
            return $message;
        }

        return false;
    }
    public function getList($data){
        return array_map('get_object_vars', $data);
    }

    /**
     * 添加一条消息
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function addMessageItem($data)
    {
        // 避免无关参数及初始化部分数据
        unset($data['message_id'], $data['page_views']);

        $message = Message::create($data);
        $message ->create_time = time();
        $message ->update_time = time();
        if ($message->save()) {
            return $message->toArray();
        }

        return false;

    }
    /**
     * 获取消息列表(后台)
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getMessageList($data)
    {
        // 搜索条件
        is_empty_parm($data['type']) ?: $map[] = ['type','=', $data['type']];
        empty($data['title']) ?: $map[] = ['title','like', '%' . $data['title'] . '%'];
        is_empty_parm($data['is_top']) ?: $map[] = ['is_top','=', $data['is_top']];
        is_empty_parm($data['status']) ?: $map[] = ['status','=', $data['status']];
        $map[] = !is_empty_parm($data['member']) ? ['member','=', $data['member']] : ['member','!=', 0];
        $map[] = ['is_delete','=', 0];

        $totalResult = self::where($map)->count();
        if ($totalResult <= 0) {
            return ['total_result' => 0];
        }
        // 翻页页数
        $pageNo = isset($data['page_no']) ? $data['page_no'] : 1;

        // 每页条数
        $pageSize = isset($data['page_size']) ? $data['page_size'] : 20;
        // 排序方式
        $orderType = !empty($data['order_type']) ? $data['order_type'] : 'desc';
        $page=$pageNo-1;
        if ($page != 0) {
            $startNum = $pageSize * $page;
        }else{
            $startNum =0;
        }
        // 排序的字段
        $orderField = !empty($data['order_field']) ? $data['order_field'] : 'message_id';
        $result = Message::where($map)
            ->orderBy($orderField,$orderType)
            ->offset($startNum)
            ->limit($pageSize)
            ->get()->toArray();
        foreach ($result as $key=>$value){
            if($value['create_time']){
                $result[$key]['create_time'] = date("Y-m-d H:i:s",$value['create_time']);
            }
        }
        if (false !== $result) {
            return ['items' => $result, 'total_result' => $totalResult];
        }

        return false;
    }

    /**
     * 获取一条消息(后台)
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getMessageItem($data)
    {
        $map[] = ['message_id','=', $data['message_id']];
        $map[] = ['member','!=', 0];
        $map[] = ['is_delete','=', 0];
        $result = Message::where($map)->get()->first();
        if(isset($result->update_time)&&$result->update_time){
            $result->update_time = date("Y-m-d H:i:s",$result->update_time );
        }
        if ($result) {
            return is_null($result) ? null : $result->toArray();
        }

        return false;
    }


    /**
     * 编辑一条消息
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function setMessageItem($data)
    {
        $map[] = ['message_id','=', $data['message_id']];
        $map[] = ['member','!=', 0];
        $map[] = ['is_delete','=', 0];
        $result = Message::where($map)->get()->first();

        if (!$result) {
            return is_null($result) ? $this->setError('消息不存在') : false;
        }

        if ($result->status === 1) {
            return $this->setError('消息已发布，不允许编辑！');
        }
        $result->fill($data);
        if($result->save()){
            return $result->toArray();
        }
        return false;
    }
    /**
     * 批量删除消息
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delMessageList($data)
    {
        $map[] = ['member','!=', 0];
        $map[] = ['is_delete','=', 0];
        $rs = idb()->table('message')
            ->where($map)
            ->whereIn('message_id', $data['message_id'])
            ->update(['is_delete' => 1]);
        if ($rs) {
            return true;
        }
        return false;
    }
    /**
     * 批量正式发布消息
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setMessageStatus($data)
    {
        $map[] = ['member','!=', 0];
        $map[] = ['status','=', 0];
        $map[] = ['is_delete','=', 0];
        $rs = idb()->table('message')
            ->where($map)
            ->whereIn('message_id', $data['message_id'])
            ->update(['status' => 1]);
        if ($rs) {
            return true;
        }
        return false;
    }
    /**
     * 用户获取一条消息
     * @access public
     * @param  array $data 外部数据
     * @return array|false
     * @throws
     */
    public function getMessageUserItem($data)
    {
        $map[] = ['message_id','=', $data['message_id']];
        $map[] = ['status','=', 1];
        $map[] = ['is_delete','=', 0];

        $result = self::where($map)->get()->first();
        if (!$result) {
            return is_null($result) ? null : false;
        }

        // 验证是否有阅读权限
        $map2[] = ['message_id','=', $result->message_id];
        $map2[] = [is_client_admin() ? 'admin_id' : 'user_id','=', get_client_id()];

        $userDb = new MessageUser();
        $userResult = $userDb->where($map2)->pluck('is_delete');

        switch ($result->member) {
            case 0:
                $notReadable = $userResult === 1;
                break;
            case 1:
                $notReadable = is_client_admin() || $userResult === 1;
                break;
            case 2:
                $notReadable = !is_client_admin() || $userResult === 1;
                break;
            default:
                $notReadable = true;
        }

        if ($notReadable) {
            return null;
        }

        // 存在权限则需要插入记录与更新
        $userDb->updateMessageUserItem($data['message_id']);
        if(isset($result->update_time)&&$result->update_time){
            $result->update_time = date("Y-m-d H:i:s",$result->update_time);
        }
        return $result->toArray();
    }
    /**
     * 设置模型错误信息
     * @access public
     * @param  string $value 错误信息
     * @return false
     */
    public function setError($value)
    {
        $this->error = $value;
        return false;
    }
}