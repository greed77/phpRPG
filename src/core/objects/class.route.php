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

/**
 * TO-DO:
 * -nothing at the moment
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
	public function dispatch( $url_path )
	{
		// First we are going to grab our url path and trim the / of the
		// left and the right
		$url_path = trim( $url_path, '/' );

		// Now we are going to split the url on the / which
		// will give us an array with 2 indexes.
		$url = explode( '/', $url_path, 3 );

		// trim "/" from the left and right, just in case
		$param_url = trim( $url[2], '/' );

		// now split everything into pieces
		$param_pieces = explode( "/", $param_url );
		if ( count( $param_pieces ) > 1 )
		{ // multiple parameters passed
			$params = array();
			foreach ( $param_pieces as $key => $value )
			{
				if ( $key % 2 == 0 )
				{
					$params[ $param_pieces[ $key ] ] = $param_pieces[ $key + 1 ];
				}
				if ( ( $key + 1 ) + 1 == count( $param_pieces ) ) {
					break;
				}
			}
		}
		else
		{ // just one parameter passed
			$params = $param_url;
		}

		// $breakdown = array(
		// 	"raw"		=> $url,
		// 	"class"		=> $url[0],
		// 	"function"	=> $url[1],
		// 	"params"	=> $params,
		// 	);
		$breakdown = new stdClass();
		$breakdown->raw = $url;
		$breakdown->class = $url[0];
		$breakdown->function = $url[1];
		$breakdown->params = $params;

		return $breakdown;
	}

}
