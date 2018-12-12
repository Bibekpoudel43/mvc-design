<?php
require "vendor/autoload.php";


$category = new \Apps\Models\Category();

$category->select('slug');

dd($category);