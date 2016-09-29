<?php


spl_autoload_register(function ($class) {
    include 'src'.str_replace('\\', DIRECTORY_SEPARATOR, '/') . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
});

$app = new Bootstrap();