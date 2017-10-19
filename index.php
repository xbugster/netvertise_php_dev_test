<?php

/**
 * Load Config and Establish Autoloader
 */
require 'lib/config/config.php';
require AUTOLOADER;

/**
 * Initialize commander and handle request
 */
$comm = new \lib\Commander();
$comm->init()->handleRequest();