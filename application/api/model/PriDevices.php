<?php 
namespace app\api\model;

class PriDevices extends BaseModel
{
    protected $table='private_devices';

    public static function getDevicesByUid($uid){
    	$devices=self::where('uid','=',$uid)->all();
    	return $devices;
    }
    public static function addDevice($uid,$clientid,$username,$password,$uptopic,$downtopic){
    	$dev=self::where('clientid','=',$clientid)->find();
    	if(empty($dev)){
	    	$device=new PriDevices;
	    	$device->uid=$uid;
	    	$device->clientid=$clientid;
	    	$device->username=$username;
	    	$device->password=$password;
	    	$device->uptopic=$uptopic;
	    	$device->downtopic=$downtopic;
	    	$device->save();
	    	return $device->id;   		
    	}else{
    		return 'error';
    	}
    	

    }
    public static function deleteDevice($uid,$clientid){
    	$dev=self::where('uid','=',$uid)->where('clientid','=',$clientid)->find();
    	$dev->delete();
    }
    public static function getDeviceID($uid,$deviceid){
    	$did=self::where('uid','=',$uid)->where('clientid','=',$deviceid)->value('id');
    	return $did;
    }
    public static function getDownTopic($uid,$deviceid){
    	$downtopic=self::where('uid','=',$uid)->where('clientid','=',$deviceid)->value('downtopic');
    	return $downtopic;
    }

}

?>
