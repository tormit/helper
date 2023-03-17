<?php

require __DIR__ . '/../vendor/autoload.php';

// Replace Tormit\Helper with your actual namespace
// This assumes that your package is located in the src/ directory
$loader = new \Composer\Autoload\ClassLoader();
$loader->addPsr4('Tormit\\Helper\\', __DIR__ . '/../src/');
$loader->register();