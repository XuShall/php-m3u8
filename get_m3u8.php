<?php
//用户授权部分 来获取m3u8播放地址

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

$uid = 1;
$video_id = 1;

$sign_key = 'secret';
$token = md5($uid.$video_id.$sign_key.time());
$redis->set($uid."_".$video_id, $token);
header('Content-Type:text/json;charset=utf-8');

echo json_encode([
    'code' => 200,
    'message' => '请求成功',
    'data' => [
        'video_id' => 1,
        'video_url' => "http://".$_SERVER['HTTP_HOST']."/parse.php?video_id={$video_id}&token={$token}",
    ],
]);


