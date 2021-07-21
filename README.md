## 仅用于学习交流，切勿用于生产环境

- 代码很多值都直接定死了，生产环境下可自定调整，这里只是简单讨论实现方式
- `sign.php` 为视频切片加密脚本  
- `data/{$id}/` 为视频目录
- `parse` 内为一个简单的打包腾讯云课堂视频脚本
- `nginx` 需要单独配置
```nginx configuration
    #重写ts
    location ~ ^/data/.*\.ts {
        rewrite  ^/(.*)$  /data/index.php?key=$1  last;
    }
    #禁用视频目录
    location ~ ^/data/.*\.m3u8 {
        deny all;
    }
```

欢迎star!👏
