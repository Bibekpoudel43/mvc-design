<?php
/**
 * Created by PhpStorm.
 * User: bibek
 * Date: 13/12/18
 * Time: 18:43
 */

namespace Apps\Models;
use System\Core\Models;

class Article extends Models
{
    protected $table = 'articles';


    public function index()
    {
        echo "ram";
    }
}