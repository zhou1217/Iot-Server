<?php


namespace app\api\service;


use app\api\model\User;
use app\lib\exception\WeChatException;
use think\facade\Cache;
use think\Exception;
use app\api\model\User as UserModel;
use think\session\driver\Redis;
use Firebase\JWT\JWT;

class UserToken
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code=$code;  //获取用户发过来的code码
        $this->wxAppId=config('wx.app_id');  //自己的appid
        $this->wxAppSecret=config('wx.app_secret');  //自己的appsecret
        $this->wxLoginUrl=sprintf(config('wx.login_url'),$this->wxAppId,$this->wxAppSecret,$this->code);  //拼接出请求地址
    }
	//向微信服务器发送请求获取openid
    public function get(){
        $result=curl_get($this->wxLoginUrl);  //发送请求
        $wxResult=json_decode($result,true);  
        if(empty($wxResult)){
            throw new Exception('获取session_key异常');
        }
        else{
            $loginFail=array_key_exists('errcode',$wxResult); //检验请求的数据是否正确
            if($loginFail){
                $this->processLogError($wxResult);
            }
            else{
                return $this->grantToken($wxResult);    
            }
        }
    }
	//生成jwt，保存用户id
    private function grantjwt($uid){
        $key="token";
        $token=[
            "iss"=>"",
            "aud"=>"",
            "iat"=>time(),
            "nbf"=>time()+1,
            "exp"=>time()+7200,
            "uid"=>$uid
        ];
        $jwt=JWT::encode($token,$key,"HS256");
        return $jwt;
    }
	
	//检验用户openid，生成jwt
    private function grantToken($wxResult){
        $openid=$wxResult['openid'];  //获取请求结果中的openid
        $user=UserModel::getByOpenID($openid);  //通过openid查找数据中的用户
        if($user){
            $uid=$user->id;
        }
        else{
            $uid=$this->newUser($openid);    //用户不存在创建用户
        }
        $token=self::grantjwt($uid);  
        return $token;
    }
	//创建用户
    private function newUser($openid){
        $user=UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }
    private function processLogError($wxResult){
        throw new WeChatException([
            'msg'=>$wxResult['errmsg'],
            'errCode'=>$wxResult['errcode']
        ]);
    }

	//校验token是否正确，并获取储存的uid
    public static function checkjwt($token){
        $key="token";
        $info=JWT::decode($token,$key,["HS256"]);
        return $info->uid;
        
    }

    public static function getUid($token){
        if($token==''){
            throw new ParameterException([
                'Token不允许为空'
            ]);
        }
        $uid=UserToken::checkjwt($token);
        return $uid;
    }


}