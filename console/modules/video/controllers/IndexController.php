<?php
namespace console\modules\video\controllers;

use Yii;
use yii\console\Controller;

/**
 * Site controller
 */
class IndexController extends Controller
{
   
    // sw tcp 服务
    private $_tcp;
    
    // 入口函数
    public function actionRun()
    {
        $this->_tcp = new \swoole_websocket_server('0.0.0.0', 9501);
        $this->_tcp->on('open', [$this, 'onConnect']);
        $this->_tcp->on('message', [$this, 'onReceive']);
        $this->_tcp->on('close', [$this, 'onClose']);
        $this->_tcp->start();
    }
    // sw connect 回调函数
    public function onConnect($server, $fd)
    {
        echo "connection open: {$fd}\n";
    }
    // sw receive 回调函数
    public function onReceive($server, $fd, $reactor_id, $data)
    {
        // 向客户端发送数据
        $server->send($fd, "Swoole: {$data}");
        // 关闭客户端
        $server->close($fd);
    }
    // sw close 回调函数
    public function onClose($server, $fd)
    {
        echo "connection close: {$fd}\n";
    }
   
}
