<?php
if(!function_exists('redirect')){
    function redirect($url){
        header("location:{url}");
    }
}

if(!function_exists('config')){
    function config($key){
        require "config/settings.php";
        if(key_exists($key, $setting )){
            return $setting[$key];
        }
        else
            {
            return false;
        }
    }
}

if(!function_exists('url')){
    function url($uri = ''){
        $base_url = config('url');
        if($base_url[(strlen($base_url)-1)]=='/' || (!empty($uri) && $uri[0]=='/')){
            return $base_url.$uri;
        }else{
            return $base_url.'/'.$uri;
        }
    }
}

