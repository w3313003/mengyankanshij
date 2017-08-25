<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function resultArray($array)
{
    if(isset($array['data'])) {
        $array['error'] = '';
        $code = 200;
    } elseif (isset($array['error'])) {
        $code = 400;
        $array['data'] = '';
    }
    return [
        'code'  => $code,
        'data'  => $array['data'],
        'error' => $array['error']
    ];
}

function setSessionCookie($k, $v) {
    session($k, $v);
    cookie($k, $v);
}

function getSessionCookie($k) {
    $s_k = session($k);
    $rs = $s_k ? $s_k : cookie($k);
    return $rs;
}
function emptySessionCookie($k) {
    session($k, null);
    cookie($k, null);
}
function create_erweima($content, $size = '100', $lev = 'L', $margin= '0') {    $content = urlencode($content);
    $image = '<img src="http://chart.apis.google.com/chart?chs='.$size.'x'.$size.'&amp;cht=qr&chld='.$lev.'|'.$margin.'&amp;chl='.$content.'"  widht="'.$size.'" height="'.$size.'" />';
    return $image;
}