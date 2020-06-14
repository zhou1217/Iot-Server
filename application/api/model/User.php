<?php


namespace app\api\model;


class User extends BaseModel
{
    protected $table='iotusers';

    public static function getByOpenID($openid){
        $user=self::where('openid','=',$openid)->find();
        return $user;
    }
    public static function getByUid($uid){
        $user=self::where('id','=',$uid)->find();
        return $user;
    }
    public static function setLogin($uid){
    	$user=self::where('id','=',$uid)->find();
    	$user->islogout=0;
    	$user->save();
    	return $user->islogout;
    } 
    public static function setLogout($uid){
     	$user=self::where('id','=',$uid)->find();
    	$user->islogout=1;
    	$user->save();
    	return $user->islogout;   	
    }
    public static function bindPriDevice($uid,$clientid,$username,$password,$uptopic){
    	$user=self::where('id','=',$uid)->find();
    	$user->priclientid=$clientid;
    	$user->priusername=$username;
    	$user->pripassword=$password;
    	$user->priuptopic=$uptopic;
    	$user->save();
    	return $user;
    }
    public static function bindAliDevice($uid,$productkey,$devicename,$devicesecret,$uptopic){
    	$user=self::where('id','=',$uid)->find();
    	$user->aliproductkey=$productkey;
    	$user->alidevicename=$devicename;
    	$user->alidevicesecret=$devicesecret;
    	$user->aliuptopic=$uptopic;
    	$user->save();
    	return $user;
    }
    public static function addPriDeviceNum($uid){
    	$user=self::where('id','=',$uid)->find();
    	$num=$user->privatenum;
    	$user->privatenum=$num+1;
    	$user->save();
    	return $user->privatenum;
    }
    public static function addAliDeviceNum($uid){
    	$user=self::where('id','=',$uid)->find();
    	$num=$user->aliyunnum;
    	$user->aliyunnum=$num+1;
    	$user->save();
    	return $user->aliyunnum;
    }
}