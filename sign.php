<?php
//假设视频已经成功上传  存在  data/1/test.mp4 文件
$video_id = 1;

//生成key 和 iv
$hash = shell_exec("cd data/{$video_id}/ && openssl rand  16 > enc.key && openssl rand -hex 16");

//生成 keyinfo
$file = fopen("data/{$video_id}/video.keyinfo", 'w');
$key_url = "/data/{$video_id}/enc.key";
fwrite($file, $key_url."\n");
fwrite($file, "enc.key"."\n");
fwrite($file, $hash."\n");

//生成m3u8相关文件
shell_exec('cd data/'.$video_id.'/ && ffmpeg -y -i test.mp4  -hls_time 12  -hls_key_info_file video.keyinfo -hls_playlist_type vod -hls_segment_filename "file%d.ts" playlist.m3u8');

