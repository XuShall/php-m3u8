<?php

//首先获取在网页上下载的m3u8格式的文件
$txt = file_get_contents('use.m3u8');

$partten = '/URI=[\'\"]?([^\'\"]*)[\'\"]?/m';
preg_match_all($partten, $txt, $match);

$patternRetcount = -1;
function patternRet()
{
    global $patternRetcount;
    $patternRetcount++;

    return 'URI="test'.$patternRetcount.'.key"';
}

$uris = $match[1];
foreach ($uris as $k => $uri) {
    $key = file_get_contents($uri);
    file_put_contents('test'.$k.".key", $key);
}
$new = preg_replace_callback($partten, "patternRet", $txt);

$partten = '/v.f30742.ts.*$/m';

//获取到ts文件的url
$ts_uri = "https://1258712167.vod2.myqcloud.com/fb8e6c92vodtranscq1258712167/59f4408c5285890788302317812/drm/";
preg_match_all($partten, $txt, $match);

$new = preg_replace_callback($partten, "getTs", $new);

$ts_key = -1;
function getTs()
{
    global $ts_key;
    $ts_key++;
    return "test{$ts_key}.ts";
}

file_put_contents('new.m3u8', $new);
foreach ($match[0] as $k=>$url) {
    $ts_url = $ts_uri.$url;
    $ts_data = file_get_contents($ts_url);
    file_put_contents('test'.$k.".ts", $ts_data);
}

//打包合并
$bash = "ffmpeg -allowed_extensions ALL -i new.m3u8 -c copy xben.mp4";
shell_exec($bash);


