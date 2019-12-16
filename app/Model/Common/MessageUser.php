<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2019/11/14
 * Time: 9:32
 */

namespace W7\App\Model\Common;

use W7\Core\Database\ModelAbstract;
class MessageUser extends ModelAbstract
{
    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    // 表名设置
    protected $table = 'message_user';
    // 主键设置
    protected $primaryKey  = 'message_user_id';

    protected $fillable = ['message_id','user_id','admin_id','is_read','is_delete'];
    public $timestamps    = false;


    /**
     * 用户批量设置消息已读
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setMessageUserRead($data)
    {
        !isset($data['type']) ?: $map[] = ['type','=', $data['type']];
        $map[] = ['member','=', is_client_admin() ? 2 : 1];
        $map[] = ['status','=', 1];
        $map[] = ['is_delete','=', 0];

        $messageId = Message::where($map) ->whereIn('message_id', $data['message_id'])->pluck('message_id')->toArray();
        if (empty($messageId)) {
            return true;
        }
        return $this->updateMessageUserList($messageId, 'is_read');
    }


    /**
     * 插入记录或更新单条记录,并设为已读状态
     * @access public
     * @param  int $messageId 消息编号
     * @return bool
     * @throws
     */
    public function updateMessageUserItem($messageId)
    {
        $clientType = is_client_admin() ? 'admin_id' : 'user_id';
        $map[] = ['message_id','=', $messageId];
        $map[] = [$clientType,'=', get_client_id()];
        $result = self::where($map)->get()->first();

        if (false === $result) {
            return false;
        }

        // 存在则更新为已读

        if ($result) {
            $result->is_read =1;
            $result->save();
            return true;
        }
//
        $data = ['message_id' => $messageId, $clientType => get_client_id(), 'is_read' => 1];
        $messageUser = new MessageUser();
        $messageUser->create_time = time();
        if($messageUser->create($data)->save()){
            return true;
        }else{
            return false;
        }

    }

    /**
     * 用户设置消息全部已读
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function setMessageUserAllRead($data)
    {
        !isset($data['type']) ?: $map[] = ['type','=', $data['type']];
        $map[] = ['member','=', is_client_admin() ? 2 : 1];
        $map[] = ['status','=', 1];
        $map[] = ['is_delete','=', 0];

        $messageId = Message::where($map)->pluck('message_id')->toArray();
        if (empty($messageId)) {
            return true;
        }

        return $this->updateMessageUserList($messageId, 'is_read', true);
    }
    /**
     * 批量插入记录或更新记录
     * @access public
     * @param  array  $messageId 消息编号
     * @param  string $field     字段
     * @param  bool   $isAll     是否操作所有
     * @return bool
     */
    private function updateMessageUserList($messageId, $field, $isAll = false)
    {
        // 获取已存在的消息
        $clientType = is_client_admin() ? 'admin_id' : 'user_id';
        $map[] = [$clientType,'=', get_client_id()];
        $map[] = ['is_read','=', 0];
        $unreadList = self::where($map)->whereIn('message_id', $messageId)->pluck('message_id')->toArray();
        // 补齐不存在记录
        $notExistsId = array_diff($messageId, $unreadList);
        idb()->beginTransaction();
        if (!empty($notExistsId)) {
            $dataUser = null;
            foreach ($notExistsId as $item) {
                $dataUser[] = [
                    'message_id'  => $item,
                    $clientType   => get_client_id(),
                    $field        => 1,
                    'create_time' => time(),
                ];
            }
            $rs = idb()->table('message_user')->insert($dataUser);
            if (!$rs) {
                idb()->rollBack();
                return false;
            }
        }

        // 更新已存在记录
        if (true === $isAll) {
            $existsId = array_intersect($messageId, $unreadList);

            if (!empty($existsId)) {
                $rs = idb()->table('message_user')
                    ->where($map)
                    ->whereIn('message_id',$existsId)
                    ->update([$field => 1]);
                if (!$rs) {
                    idb()->rollBack();
                    return false;
                }
            }

        } else {
            $existsId = array_intersect($messageId, $unreadList);
            if (!empty($existsId)) {
                $rs = idb()->table('message_user')
                    ->where($map)
                    ->whereIn('message_id',$existsId)
                    ->update([$field => 1]);
                if (!$rs) {
                    idb()->rollBack();
                    return false;
                }
            }
        }
        idb()->commit();
        return true;
    }

    /**
     * 用户批量删除消息
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delMessageUserList($data)
    {
        !isset($data['type']) ?: $map[] = ['type','=', $data['type']];
        $map[] = ['member','=', is_client_admin() ? 2 : 1];
        $map[] = ['status','=', 1];
        $map[] = ['is_delete','=', 0];

        $messageId = Message::where($map)->whereIn('message_id', $data['message_id'])->pluck('message_id')->toArray();
        if (empty($messageId)) {
            return true;
        }

        return $this->updateMessageUserList($messageId, 'is_delete');
    }
    /**
     * 用户删除全部消息
     * @access public
     * @param  array $data 外部数据
     * @return bool
     */
    public function delMessageUserAll($data)
    {
        !isset($data['type']) ?: $map[] = ['type','=', $data['type']];
        $map[] = ['member','=', is_client_admin() ? 2 : 1];
        $map[] = ['status','=', 1];
        $map[] = ['is_delete','=', 0];

        $messageId = Message::where($map)->pluck('message_id')->toArray();
        if (empty($messageId)) {
            return true;
        }
        return $this->updateMessageUserList($messageId, 'is_delete', true);
    }
}