<?php


if ($_GET['play_id'] != 'test_play_id') {
    die;
}

//通过play_id 获取视频加密key
echo file_get_contents('data/1/enc.key');