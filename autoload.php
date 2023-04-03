<?php

require_once 'vendor/autoload.php';

// Register the MyLibrary namespace
$loader = new \Composer\Autoload\ClassLoader();
$loader->addPsr4('ApiClient\\', __DIR__ . '/src/');
$loader->register();