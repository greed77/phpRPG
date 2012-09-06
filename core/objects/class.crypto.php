<?php
// prevent this file being called directly
if ( !defined( 'phpRPG' ) )
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit();
}

/**
 * Simple encryption class
 */

class crypto
{
	/**
	 * Constructor
	 */
	public function __construct() {}

	public function encrypt( $data )
	{
		// do something to encrypt the data
		$encrypted = $data;

		// return encrypted string
		return $encrypted;
	}

	public function decrypt( $data )
	{
		// do something to decrypt the data
		$decrypted = $data;

		// return decrypted string
		return $decrypted;
	}

}
