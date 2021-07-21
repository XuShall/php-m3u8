<?php

//根据 uid video_id 获取 play_id 用于获取加密key 这里自己进行相关处理

header('Content-Type:text/json;charset=utf-8');

$uid = 1;
$video_id = 1;

$return = [
    'code' => 200,
    'data' => ['play_id' => 'test_play_id'],
    'message' => '请求成功',
];

echo json_encode($return);