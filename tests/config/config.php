<?php
/**
 * Configuration of the system.
 */

/**
 * Paths
 */
define( 'DS', DIRECTORY_SEPARATOR );
define( 'BASE_PATH',  str_replace( 'tests' . DS . 'config', '', dirname( __FILE__ ) ) );
define( 'AUTOLOADER', BASE_PATH . 'lib' . DS . 'helpers' . DS . 'autoloader.php' );

/**
 * DB Settings
 */
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_USER', 'root' );
define( 'DB_PWD',  'toor' );
define( 'DB_NAME', 'comments' );

/**
 * Defaults
 */
define( 'DEFAULT_EVENT', 'ShowComments' );

/**
 * Debug options
 */
error_reporting( E_ALL );
ini_set( 'display_error', 1 );