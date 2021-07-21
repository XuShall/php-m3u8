<?php

//可以加授权判断

$root_dir = __DIR__."/../";
echo file_get_contents($root_dir.$_GET['key']);