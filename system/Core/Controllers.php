<?php

namespace System\Core;


use System\Exceptions\FileNotFoundException;
use System\Exceptions\ViewNotFoundException;

abstract class Controllers
{
    abstract public function index();

    public function view($name, $data = null)
    {
        $path = 'views/';
        $name = $this->checkExt($name);
        $file = $path.$name;

        //determine if the file exist or not
        if (is_file($file))
        {
            if (!is_null($data))
            {
                extract($data);
            }
            require $file;
        }
        else
        {
            if (config('debug'))
            {
                throw new ViewNotFoundException("View file '{$file}' does not exist");
            }
            else
            {
                throw new FileNotFoundException('Sorry Page Not Found');

            }
        }

    }

    private function checkExt($name)
    {
        $ext = substr($name, strlen($name) - 4, 4 );

        if ($ext != '.php')
        {
            $name .= '.php';
        }

        return $name;
    }
}