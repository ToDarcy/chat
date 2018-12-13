<?php
namespace app\admin\controller;
use \think\Controller;
use \Workerman\Worker;
use \GatewayWorker\Register;
use \GatewayWorker\BusinessWorker;
use \GatewayWorker\Gateway;

class RunController
{
    public function __construct()
    {
        // 初始化register
        new Register('text://0.0.0.0:1237');

        //初始化 bussinessWorker 进程
        $worker = new BusinessWorker();
        $worker->name = 'RoomCustomerService';
        $worker->count = 4;
        $worker->registerAddress = '127.0.0.1:1237';

        // 设置处理业务的类,此处制定Events的命名空间
        $worker->eventHandler = '\app\admin\controller\EventsController';
        // 初始化 gateway 进程
        $gateway = new Gateway("websocket://0.0.0.0:8282");
        $gateway->name = 'RoomGateway';
        $gateway->count = 4;
        $gateway->lanIp = '127.0.0.1';
        $gateway->startPort = 2900;
        $gateway->registerAddress = '127.0.0.1:1237';

        // 运行所有Worker;
        Worker::runAll();
    }
}
