<?php

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Log;
class Activity{
    //Gateway::sendToClient($client_id, "找到了\r\n");
    //Gateway::sendToAll("$client_id said $message\r\n");
    //Log::write("来了");

    //活动的统一前缀
    private static $_group_prev = "student_activity_";

    /**
     * 加入分组
     */
    public static function joinActivityGroup($client_id, $message) {
        $group_name = self::getGroupName($message['params']['activity_id']);
        if ($group_name) {
            Gateway::joinGroup($client_id, $group_name);
        }
    }

    /**
     * 获取小组名称
     */
    public static function getGroupName($activity_id) {
        return self::$_group_prev . $activity_id;
    }

    /**
     * 给分组发送消息
     * 学生主题活动互动的格式
     * {
     *      'activity_id' => 1, //活动id
     *      'type' => 1, //1新增 2删除
     *      'interactive_ids' => [], //互动ids
     * }
     */
    public static function sendToGroup($client_id, $message) {
        if ($message['domain'] == 'system') { //主题活动里面只有系统才能发送消息
            //给所有的分组下面所有的client发消息
            $group_name = self::getGroupName($message['params']['activity_id']);
            if ($group_name) {
                gateway::sendToGroup($group_name, json_encode($message['params']));
                Log::write($client_id. "向" .$group_name . "发送数据" . print_r($message['params'], true));
            }
        }
    }
}