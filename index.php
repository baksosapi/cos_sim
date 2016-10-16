<?php

require_once 'config.php';

spl_autoload_register(function ($class) {
    include 'src'.str_replace('\\', DIRECTORY_SEPARATOR, '/').str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
});

// Call Bootstrap
$app = new Bootstrap();
