<?php
// http://zaemis.blogspot.co.uk/2012/05/writing-minimal-psr-0-autoloader.html
spl_autoload_register(function ($classname) {
    $classname = ltrim($classname, "\\");
    preg_match('/^(.+)?([^\\\\]+)$/U', $classname, $match);
    $classname = str_replace("\\", "/", $match[1])
        . str_replace(array("\\", "_"), "/", $match[2])
        . ".php";
    include_once __DIR__ . '/' . $classname;
});