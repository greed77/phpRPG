<?php
// prevent this file being called directly
if ( !defined( 'phpRPG' ) )
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit();
}

/**
 * VERY basic URL routing
 */

class route
{
	/**
	 * Hello
	 */
	public function __construct() {}

	/**
	 * get pieces and load up appropriate classes
	 * @param Mixed $params a string from the querystring
	 * @return void
	 */
	public function dispatch( $params )
	{
		// First we are going to grab our url path and trim the / of the
		// left and the right
		$url = trim($params, '/');

		// Now we are going to split the url on the / which
		// will give us an array with 2 indexes.
		$url = explode('/', $url);

		// Let's just print out our array to get a visual of
		// what we are working with.
		phpRPGRegistry::dump($url);
	}

}
