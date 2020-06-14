<?php


namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code=400;
    public $msg='调用接口失败';
    public $errorCode=999;
}