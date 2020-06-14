<?php 
namespace app\api\model;

class AliDevices extends BaseModel
{
    protected $table='aliyun_devices';

    public static function getDevicesByUid($uid){
    	$devices=self::where('uid','=',$uid)->all();
    	return $devices;
    }
    public static function addDevice($uid,$productkey,$devicename,$devicesecret,$uptopic,$downtopic){
    	$dev=self::where('devicename','=',$devicename)->find();
    	if(empty($dev)){
	    	$device=new AliDevices;
	    	$device->uid=$uid;
	    	$device->productkey=$productkey;
	    	$device->devicename=$devicename;
	    	$device->devicesecret=$devicesecret;
	    	$device->uptopic=$uptopic;
	    	$device->downtopic=$downtopic;
	    	$device->save();
	    	return $device->id;   		
    	}else{
    		return 'error';
    	}
    	

    }
    public static function deleteDevice($uid,$devicename){
    	$dev=self::where('uid','=',$uid)->where('devicename','=',$devicename)->find();
    	$dev->delete();
    }
    public static function getDeviceID($uid,$deviceid){
    	$dev=self::where('uid','=',$uid)->where('devicename','=',$deviceid)->find();
    	return $dev->id;    	
    }

}
 ?>