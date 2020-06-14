<?php


namespace app\api\controller;
use app\api\model\User;
use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use Firebase\JWT\JWT;
use app\api\model\AliDevices;
use app\api\model\PriDevices;
use app\api\model\AliActions;
use app\api\model\PriActions;

class Token
{
    public function getToken($code=''){
        $tokenget=new TokenGet();
        $ut=new UserToken($code);
        $token=$ut->get();
        return $token;
    }
    public function isLogout($token=''){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        return $user->islogout;
    }
    public function Login($token=''){
        $uid=UserToken::getUid($token);
        return User::setLogin($uid);

    }  
    public function Logout($token=''){
    	$uid=UserToken::getUid($token);
    	return User::setLogout($uid);
    }
    public function isBindAliCloud($token){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        return json([
            	'myprikey'=>$user->aliproductkey
            	]);
    }
    public function isBindPriCloud($token){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        return json([
            	'myclientid'=>$user->priclientid
            	]);

    }

    public function bindPriCloud($token,$clientid,$username,$password,$uptopic){
    	$uid=UserToken::getUid($token);
    	$user=User::bindPriDevice($uid,$clientid,$username,$password,$uptopic);
    	return $user->priclientid;
    }
    
    public function bindAliCloud($token,$productkey,$devicename,$devicesecret,$uptopic){
    	$uid=UserToken::getUid($token);
    	$user=User::bindAliDevice($uid,$productkey,$devicename,$devicesecret,$uptopic);
    	return $user->aliproductkey;
    }
    
    public function getDeviceNum($token){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        //var_dump($user);
        $priNum=$user->privatenum;
        $aliNum=$user->aliyunnum;
        if($priNum!=0||$aliNum!=0){
            return json([
            'privatenum'=>$priNum,
            'aliyunnum'=>$aliNum
            ]);
        }
        return json([
            'privatenum'=>0,
            'aliyunnum'=>0
            ]);

    }

    public function verifyToken($token){
    	$uid=UserToken::getUid($token);
    	$user=User::getByUid($uid);
    	if(!empty($user)){
    		return 1;
    	}else{
    		return 0;
    	}
    }
    
    public function getPriDevices($token){
    	$uid=UserToken::getUid($token);
    	return PriDevices::getDevicesByUid($uid);
    }
    
    public function getAliDevices($token){
    	$uid=UserToken::getUid($token);
    	return AliDevices::getDevicesByUid($uid);
    }
    
    public function addPriDevice($token,$clientid,$username,$password,$uptopic,$downtopic){
    	$uid=UserToken::getUid($token);
    	$privatenum=User::addPriDeviceNum($uid);
    	return PriDevices::addDevice($uid,$clientid,$username,$password,$uptopic,$downtopic);
    }
    public function addAliDevice($token,$productkey,$devicename,$devicesecret,$uptopic,$downtopic){
    	$uid=UserToken::getUid($token);
    	$aliyunnum=User::addAliDeviceNum($uid);
    	return AliDevices::addDevice($uid,$productkey,$devicename,$devicesecret,$uptopic,$downtopic);
    }  
    public function deletePriDevice($token,$clientid){
    	$uid=UserToken::getUid($token);
    	PriDevices::deleteDevice($uid,$clientid);
    	return $clientid;
    }
    public function deleteAliDevice($token,$devicename){
    	$uid=UserToken::getUid($token);
    	AliDevices::deleteDevice($uid,$devicename);
    	return $devicename;
    }
    public function getDeviceAction($token,$dtype,$did){
        $uid=UserToken::getUid($token);
        $actions=null;
        if($dtype==0){
            $ddid=PriDevices::getDeviceID($uid,$did);
            $actions=PriActions::getActionByDid($ddid);
            //var_dump($did);
        }
        if($dtype==1){
            $ddid=AliDevices::getDeviceID($uid,$did);
            $actions=AliActions::getActionByDid($ddid);
        }
        return $actions;
    }
    public function addDeviceAction($token,$deviceid,$devicetype,$type,$which,$alias){
        $uid=UserToken::getUid($token);
        $action=null;
        if($devicetype==0){
            $did=PriDevices::getDeviceID($uid,$deviceid);
            $action=PriActions::addAction($did,$type,$which,$alias);
        }
        if($devicetype==1){
            $did=AliDevices::getDeviceID($uid,$deviceid);
            $action=AliActions::addAction($did,$type,$which,$alias);
        }
        return $action;
    }
    public function getBindPriDevice($token){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        return json([
            'clientid'=>$user->priclientid,
            'username'=>$user->priusername,
            'password'=>$user->pripassword,
            'uptopic'=>$user->priuptopic
        ]);

    }
    public function getBindAliDevice($token){
        $uid=UserToken::getUid($token);
        $user=User::getByUid($uid);
        return json([
            'devicename'=>$user->alidevicename,
            'productkey'=>$user->aliproductkey,
            'devicesecret'=>$user->alidevicesecret,
            'uptopic'=>$user->aliuptopic
        ]);
    }  
    public function getDownTopic($token,$deviceid){
    	$uid=UserToken::getUid($token);
    	$downtopic=PriDevices::getDownTopic($uid,$deviceid);
    	return $downtopic;
    }

}