<?php
//解析数据

error_reporting(0);
$token = $_GET['token'];
$play_id = $_GET['play_id'];
$video_id = $_GET['video_id'];

$uid = 1;

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis_token = $redis->get($uid.'_'.$video_id);

if (! $redis_token || $redis_token != $token) {
    exit('未取得授权');
}

//获取播放列表
$file_name = "data/{$video_id}/playlist.m3u8";
$file = fopen($file_name, 'r');
$file_size = filesize($file_name);
$txt = fread($file, $file_size);

//批量调整文件地址
$partten = "/(file)[0-9]\d*.ts/m";
$new = preg_replace($partten, "data/{$video_id}/$0", $txt);

//更换加密key地址
$partten= '/URI=[\'\"]?([^\'\"]*)[\'\"]?/m';
preg_match_all($partten, $new, $mataches);
$key_url = "http://".$_SERVER['HTTP_HOST']."/get_key.php?play_id=".$play_id;
$new = preg_replace($partten, 'URI="'.$key_url.'"', $new);

echo $new;

