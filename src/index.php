<?php
/**
 * phpRPG Framework
 * Framework loader - acts as a single point of access to the Framework
 *
 * @version 0.1
 * @author Given Reed
 */
 
// first and foremost, start our sessions
session_start();

// setup some definitions
// The applications root path, so we can easily get this path from files located in other folders
define( "APP_PATH", dirname( __FILE__ ) ."/" );
// We will use this to ensure scripts are not called from outside of the framework
define( "phpRPG", true );
// secure encryption key
define( "CRYPTO_SEED", "super secure encryption key" );

/** 
 * Magic autoload function
 * used to include the appropriate -controller- files when they are needed
 * @param String the name of the class
 */
function __autoload( $class_name )
{
	require_once( APP_PATH . 'plugins/' . $class_name . '/' . $class_name . '.php' );
}

// require our registry
require_once( APP_PATH . 'core/class.registry.php' );
$phpRPG = phpRPGRegistry::singleton();

// $phpRPG->storeObject( 'database', 'db', true );
$phpRPG->storeObject( 'template', 'template', true );
$phpRPG->storeObject( 'page', 'page', true );
// $phpRPG->storeObject( 'html', 'html', true );
$phpRPG->storeObject( 'route', 'route', true );

// parse out the url into usable chunks
$route = $phpRPG->getObject('route')->dispatch( $_GET['_url'] );

if ( trim( $route->class ) <> "" )
{
	// display debug info for now
	phpRPGRegistry::dump( $route, false );

	// check if class exists
	if ( $phpRPG->getObject( $route->class ) )
	{
		// check if function is specified
		if ( trim( $route->function ) <> "" )
		{
			// load appropriate class, function and pass parameters if available
			$phpRPG->getObject( $route->class )->{$route->function}( $route->params );
		}
		else
		{
			// no function passed, pass to index
			$phpRPG->getObject( $route->class )->index();
		}
	}
	else
	{
		// class doesn't exist
		// print out the frameworks name - just to check everything is working
		phpRPGRegistry::dump( $phpRPG->getFrameworkName() . " " . $phpRPG->getFrameworkVersion() );
	}
}
else
{
	// nothing in URI, display home page

	// print out the frameworks name - just to check everything is working
	phpRPGRegistry::dump( $phpRPG->getFrameworkName() . " " . $phpRPG->getFrameworkVersion() );
}

exit();
