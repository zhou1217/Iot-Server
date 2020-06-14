<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
Route::post('api/getToken','api/Token/getToken');
Route::post('api/islogout','api/Token/islogout');
Route::post('api/isbindalicloud','api/Token/isBindAliCloud');
Route::post('api/isbindpricloud','api/Token/isBindPriCloud');
Route::post('api/getdevicenum','api/Token/getDeviceNum');
Route::post('api/login','api/Token/Login');
Route::post('api/logout','api/Token/Logout');
Route::post('api/verifytoken','api/Token/verifyToken');
Route::post('api/bindalicloud','api/Token/bindAliCloud');
Route::post('api/bindpricloud','api/Token/bindPriCloud');
Route::post('api/addpridevice','api/Token/addPriDevice');
Route::post('api/addalidevice','api/Token/addAliDevice');
Route::post('api/getpridevices','api/Token/getPriDevices');
Route::post('api/getalidevices','api/Token/getAliDevices');
Route::post('api/deletepridevice','api/Token/deletePriDevice');
Route::post('api/deletealidevice','api/Token/deleteAliDevice');
Route::post('api/adddeviceaction','api/Token/addDeviceAction');
Route::post('api/getdeviceaction','api/Token/getDeviceAction');
Route::post('api/getbindpridevice','api/Token/getBindPriDevice');
Route::post('api/getbindalidevice','api/Token/getBindAliDevice');
Route::post('api/getdowntopic','api/Token/getDownTopic');

return [

];
