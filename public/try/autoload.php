<?php 

spl_autoload_register(function ($classname){
    // echo $classname;
    // echo '-----------------------------------------------------------';

    require __DIR__."/{$classname}.php";
});