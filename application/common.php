<?php
function p($param){
    header("Content-type:text/html;charset=utf-8");
    print_r($param);
    echo '<br />';
}
function pe($param){
    header("Content-type:text/html;charset=utf-8");
    print_r($param);
    echo '<br />';
    exit;
}
function createGuid($hyphen = '') {
    mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid,12, 4) . $hyphen
            . substr($charid,16, 4) . $hyphen
            . substr($charid,20,12);
    return $uuid;
}