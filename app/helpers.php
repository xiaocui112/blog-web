<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}
/**
 * 截取字符
 *
 * @param string $value
 * @param integer $lenth
 * @return string
 */
function make_excerpt($value,$lenth=200){
    $excerpt=trim(preg_replace('/\r\n|\r|\n+/',' ',strip_tags($value)));
    return Str::limit($excerpt,$lenth);
}