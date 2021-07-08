<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id,json_encode([
            'type'=>'init',
            'client_id'=>$client_id
        ]));
    }
    
   /**
    * 当客户端发来消息时触发
    * @param int $client_id 连接id
    * @param mixed $message 具体消息
    */
   public static function onMessage($client_id, $message)
   {
       $message_data = json_decode($message,true);
       if(!$message_data){
           return;
       }
       switch($message_data['type']) {
           case "bind": // fromid(userId)和gatewayworker的client_id绑定
               $fromid = $message_data['fromid'];
               Gateway::bindUid($client_id, $fromid);
               return;
           case "say": // 消息推送给指定id
               $text = nl2br(htmlspecialchars($message_data['data']));
               $fromid = $message_data['fromid'];
               $toid = $message_data['toid'];
               $date = [
                   'type' => 'say',
                   'data' => $text,
                   'fromid' => $fromid,
                   'toid' => $toid,
                   'time' => time()
               ];

               if (Gateway::isUidOnline($toid)) {
                   $date['isread'] = 1 ;
                   Gateway::sendToUid($toid, json_encode($date));
               } else {
                   $date['isread'] = 0;
               }
               $date['type'] = "save";
               Gateway::sendToUid($fromid, json_encode($date));      // 消息推送给本机，并做数据持久化
               return;
           case "online": // 推送对方在线状态
               $toid = $message_data['toid'];
               $fromid = $message_data['fromid'];
               $toidStatus = Gateway::isUidOnline($toid);
               $fromidStatus = Gateway::isUidOnline($fromid);
               $toid_client_id = Gateway::getClientIdByUid($toid);
               $fromid_client_id = Gateway::getClientIdByUid($fromid);
               Gateway::sendToUid($fromid, json_encode(['type' => "online", "status" => $toidStatus
                   , "toid_client_id" => $toid_client_id[0], "fromid_client_id" => $fromid_client_id[0]]));
               Gateway::sendToUid($toid, json_encode(['type' => "online", "status" => $fromidStatus
                   , "toid_client_id" => $fromid_client_id[0], "fromid_client_id" => $toid_client_id[0]]));
               return;
       }
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       // 向所有人发送
       //GateWay::sendToAll(json_encode(['type'=>"onclose","client_id"=>$client_id]),[1]);
   }
}
