<?php

namespace System\Core;


class SystemInit
{

    public function start()
    {
        //entry point for system
        $url_parts = $this->getUrlParts();

        dd($url_parts);
    }

    private function getUrlParts()
    {
        $full_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $base_url = url();

        $partial = str_replace($base_url, '', $full_url);

        $parts = explode('?', $partial);

        $parts_arr =  explode('/', $parts[0]);

        $ret = [];

        if (isset($parts_arr[0]) && !empty($parts_arr[0]))
        {
            $ret['controller'] = $parts_arr[0];
        }
        else
        {
            $ret['controller'] =config('default_controller');
        }
        if (isset($parts_arr[1]) && !empty($parts_arr[1]))
        {
            $ret['method'] = $parts_arr[1];
        }
        else
        {
            $ret['method'] = 'index';
        }
        if (isset($parts_arr[2]) && !empty($parts_arr[2]))
        {
            $ret['argument'] = $parts_arr[2];
        }
        else
        {
            $ret['argument'] = 'null';
        }
    }

}