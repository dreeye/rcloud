<?php

namespace Dreeye\Rcloud;

use Dreeye\Rcloud\Core;
use \Exception;

class Api extends Core {

    public function __construct($appKey,$appSecret,$format = 'json'){
        parent::__construct($appKey,$appSecret,$format = 'json');
    }
   
    /**
     * 一个用户向一个或多个用户发送系统消息
     * @param $fromUserId       发送人用户 Id。（必传）
     * @param $toUserId         接收用户Id，提供多个本参数可以实现向多用户发送系统消息。（必传）
     * @param $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent   如果为自定义消息，定义显示的 Push 内容。(可选)
     * @param string $pushData  针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     * @return json|xml
     */
    public function messageSystemPublish($fromUserId,$toUserId = array(),$objectName,$content,$pushContent='',$pushData = '') {
        if(empty($fromUserId))
            throw new Exception('发送人用户 Id 不能为空');
        if(empty($toUserId))
            throw new Exception('接收用户 Id 不能为空');
        if(empty($objectName))
            throw new Exception('消息类型 不能为空');
        if(empty($content))
            throw new Exception('发送消息内容 不能为空');
        $params = array(
            'fromUserId' => $fromUserId,
            'objectName' => $objectName,
            'content' => $content,
            'pushContent' => $pushContent,
            'pushData' => $pushData,
            'toUserId' => $toUserId
        );
        $ret = $this->curl('/message/system/publish',$params);
        if(empty($ret))
            throw new Exception('请求失败');
        return $ret;
    }

    
    /**
     * 获取 Token 方法
     * @param $userId   用户 Id，最大长度 32 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。
     * @param $name     用户名称，最大长度 128 字节。用来在 Push 推送时，或者客户端没有提供用户信息时，显示用户的名称。
     * @param $portraitUri  用户头像 URI，最大长度 1024 字节。
     * @return json|xml
     */
    public function getToken($userId, $name, $portraitUri) {
        if(empty($userId))
            throw new Exception('用户 Id 不能为空');
        if(empty($name))
            throw new Exception('用户名称 不能为空');
        if(empty($portraitUri))
            throw new Exception('用户头像 URI 不能为空');
        $ret = $this->curl('/user/getToken',array('userId'=>$userId,'name'=>$name,'portraitUri'=>$portraitUri));
        if(empty($ret))
            throw new Exception('请求失败');
        return $ret;
    }
}
