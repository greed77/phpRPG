<?php
// prevent this file being called directly
if ( !defined( 'phpRPG' ) ) 
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit();
}

/**
 * Template manager class
 */
class page
{
	public function index()
	{
		phpRPGRegistry::dump( "default function", false );
	}

	public function view( $params )
	{
		phpRPGRegistry::dump( $params, false );
	}
}