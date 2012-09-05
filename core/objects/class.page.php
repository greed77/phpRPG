<?php
// prevent this file being called directly
if ( !defined( 'phpRPG' ) )
{
	echo 'This file can only be called via the main index.php file, and not directly';
	exit();
}

/**
 * This is our page object
 * It is a seperate object to allow some interesting extra functionality to be added
 */

/**
 * TO-DO:
 * -PostParseTags: You may wish to have tags replaced <em>after</em> most of the page has been parsed, maybe content in the database contains tags which need to be parsed.
 * -Passworded pages: Assign a password to a page, check to see if the user has the password in a cookie or a session to allow them to see the page.
 * -Restricted pages (although we need our authentication components first!)
 * -Altering the <body> tag depending on the page e.g. adding a google maps call.
 * -Dynamically adding references to javascript and css files based on the page or application.
 */

class page
{
	// room to grow later?
	private $css = array();
	private $js = array();
	private $bodyTag = '';
	private $bodyTagInsert = '';

	// future functionality?
	private $authorised = true;
	private $password = '';

	// page elements
	private $title = '';
	private $tags = array();
	private $postParseTags = array();
	private $bits = array();
	private $content = "";

	/**
	 * Constructor...
	 */
	function __construct() { }

	public function getTitle()
	{
		return $this->title;
	}

	public function setPassword( $password )
	{
		$this->password = $password;
	} 

	public function setTitle( $title )
	{
		$this->title = $title;
	}

	public function setContent( $content )
	{
		$this->content = $content;
	}

	public function addTag( $key, $data )
	{
		$this->tags[$key] = $data;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function addPPTag( $key, $data )
	{
		$this->postParseTags[$key] = $data;
	}

	/**
	 * Get tags to be parsed after the first batch have been parsed
	 * @return array
	 */
	public function getPPTags()
	{
		return $this->postParseTags;
	}

	/**
	 * Add a template bit to the page, doesnt actually add the content just yet
	 * @param String the tag where the template is added
	 * @param String the template file name
	 * @return void
	 */
	public function addTemplateBit( $tag, $bit )
	{
		$this->bits[ $tag ] = $bit;
	}

	/**
	 * Get the template bits to be entered into the page
	 * @return array the array of template tags and template file names
	 */
	public function getBits()
	{
		return $this->bits;
	}

	/**
	 * Gets a chunk of page content
	 * @param String the tag wrapping the block ( <!-- START tag --> block <!-- END tag --> )
	 * @return String the block of content
	 */
	public function getBlock( $tag )
	{
		preg_match ('#<!-- START '. $tag . ' -->(.+?)<!-- END '. $tag . ' -->#si', $this->content, $tor);
		
		$tor = str_replace ('<!-- START '. $tag . ' -->', "", $tor[0]);
		$tor = str_replace ('<!-- END '  . $tag . ' -->', "", $tor);
		
		return $tor;
	}

	public function getContent()
	{
	return $this->content;
	}

}
