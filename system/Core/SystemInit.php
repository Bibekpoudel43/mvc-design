<?php

namespace System\Core;

use System\Exceptions\ControllerFileNotFoundException;
use System\Exceptions\FileNotFoundException;
use System\Exceptions\MethodNotFoundException;
use System\Exceptions\NotControllerException;

class SystemInit
{

    public function __construct()
    {
        date_default_timezone_set(config('timezone'));
    }

    public function start(){
        try {
            $url_parts = $this->getUrlParts();
            $this->loadController($url_parts);
        }
        catch (FileNotFoundException $e){
            echo $e->getMessage();
        }
        catch (\Exception $e){
            echo $e->getMessage();
            dump($e->getTrace());
        }

  }

  private function getUrlParts(){
      $full_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];


      $base_url = url();

      $partial = str_replace($base_url,'',$full_url);
      $parts = explode('?',$partial);

      $parts_arr = explode('/',$parts[0]);
      $ret=[];

      if (isset($parts_arr[0])&& !empty($parts_arr[0])){
          $ret['controller']= $parts_arr[0];
      }else{
          $ret['controller']=config('default_controller');
      }

      if (isset($parts_arr[1])&& !empty($parts_arr[1])){
          $ret['method']= $parts_arr[1];
      }else{
          $ret['method']='index';
      }

      if (isset($parts_arr[2])&& !empty($parts_arr[2])){
          $ret['argument']= $parts_arr[2];
      }else{
          $ret['argument']=null;
      }

      return $ret;
  }

  private function loadController($url_parts)
  {
      $debug = config('debug');
      $ctrlName = ucfirst($url_parts['controller'] . 'Controller');
      if (is_file('apps/Controllers/' . $ctrlName . '.php')) {
          $className = "Apps\Controllers\\" . $ctrlName;
          $classObj = new $className;
          if ($classObj instanceof Controllers) {
              if (method_exists($classObj, $url_parts['method'])) {
                  if (is_null($url_parts['argument'])) {
                      $classObj->{$url_parts['method']}();
                  } else {
                      $classObj->{$url_parts['method']}($url_parts['argument']);
                  }
              }
              else {
                  if ($debug) {
                      throw new MethodNotFoundException("Method '{$url_parts['method']}' not found in the class {$className}.");
                  } else {
                      throw new FileNotFoundException("sorry! page not found.");
                  }
              }
          }
          else {
              if ($debug) {
                  throw new NotControllerException("class '{$className}' must inherit 'System\Core\Controllers' class.");
              } else {
                  throw new FileNotFoundException("sorry! page not found.");
              }
          }
      }
      else {
          if ($debug) {
              throw new ControllerFileNotFoundException("'{$ctrlName}.php' file not found inside inside 'apps/Controller'.");
          } else {
              throw new FileNotFoundException("sorry! page not found.");
          }
      }
  }
}