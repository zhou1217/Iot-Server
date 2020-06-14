<?php


namespace app\api\validate;


use think\Validate;

class TokenGet extends BaseValidate
{
    protected $rule=[
        'code'=>'require',
        'token'=>'require|isNotEmpty'
    ];
    protected $message=[
      'code'=>'没有code',
      'token'=>'没有传入令牌'
    ];
}