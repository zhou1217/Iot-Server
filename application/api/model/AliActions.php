<?php 
namespace app\api\model;

/**
 * 
 */
class AliActions extends BaseModel
{
	protected $table='aliyun_devices_action';

	public static function getActionByDid($deviceID){
		$actions=self::where('did','=',$deviceID)->all();
		return $actions;		
	}
	public static function addAction($did,$type,$which,$alias){
		$action=new AliActions;
		$action->did=$did;
		$action->dtype=$type;
		$action->which=$which;
		$action->alias=$alias;
		$action->save();
		return $action;

	}
}
 ?>