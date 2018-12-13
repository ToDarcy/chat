<?php
namespace app\chat\controller;
use think\Controller;

class ChatController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }



}
