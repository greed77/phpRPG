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
class template
{
	private $html;

	/**
	 * Hello!
	 */
	public function __construct() 
	{
		include( APP_PATH . 'core/objects/class.html.php');
		$this->html = new html();
	}

	/**
	 * Add a template bit onto our page
	 * @param String $tag the tag where we insert the template e.g. {{hello}}
	 * @param String $bit the template bit (path to file, or just the filename)
	 * @return void
	 */
	public function addTemplateBit( $tag, $bit )
	{
		if( strpos( $bit, 'skins/' ) === false )
		{
			$bit = APP_PATH . 'skins/' . phpRPGRegistry::getSetting('skin') . '/templates/' . $bit;
		}
		$this->html->addTemplateBit( $tag, $bit );
	}

	/**
	 * Put the template bits into our page content
	 * Updates the pages content
	 * @return void
	 */
	private function replaceBits()
	{
		$bits = $this->html->getBits();
		foreach( $bits as $tag => $template )
		{
			$templateContent = file_get_contents( $bit );
			$newContent = str_replace( '{{' . $tag . '}}', $templateContent, $this->html->getContent() );
			$this->html->setContent( $newContent );
		}
	}

	/**
	 * Replace tags in our page with content
	 * @return void
	 */
	private function replaceTags()
	{
		// get the tags
		$tags = $this->html->getTags();
		// go through them all
		foreach( $tags as $tag => $data )
		{
			if( is_array( $data ) )
			{
			  
				if( $data[0] == 'SQL' )
				{
					// it is a cached query...replace DB tags
					$this->replaceDBTags( $tag, $data[1] );
				}
				elseif( $data[0] == 'DATA' )
				{
					 // it is some cached data...replace data tags
					$this->replaceDataTags( $tag, $data[1] );
				}
			}
			else
			{	
				// replace the content	    	
				$newContent = str_replace( '{{' . $tag . '}}', $data, $this->html->getContent() );
				// update the pages content
				$this->html->setContent( $newContent );
			}
		}
	}

	/**
	 * Replace content on the page with data from the DB
	 * @param String $tag the tag defining the area of content
	 * @param int $cacheId the queries ID in the query cache
	 * @return void
	 */
	private function replaceDBTags( $tag, $cacheId )
	{
		$block = '';
		$blockOld = $this->html->getBlock( $tag );
		
		// foreach record relating to the query...
		while ($tags = phpRPGRegistry::getObject('db')->resultsFromCache( $cacheId ) )
		{
			$blockNew = $blockOld;
			// create a new block of content with the results replaced into it
			foreach ($tags as $ntag => $data) 
			{
				$blockNew = str_replace("{{" . $ntag . "}}", $data, $blockNew); 
			}
			$block .= $blockNew;
		}
		$pageContent = $this->html->getContent();
		// remove the seperator in the template, cleaner HTML
		$newContent = str_replace( '<!-- START ' . $tag . ' -->' . $blockOld . '<!-- END ' . $tag . ' -->', $block, $pageContent );
		// update the page content
		$this->html->setContent( $newContent );
	}

	/**
	 * Replace content on the page with data from the cache
	 * @param String $tag the tag defining the area of content
	 * @param int $cacheId the datas ID in the data cache
	 * @return void
	 */
	private function replaceDataTags( $tag, $cacheId )
	{
		$block = $this->html->getBlock( $tag );
		$blockOld = $block;
		while ($tags = phpRPGRegistry::getObject('db')->dataFromCache( $cacheId ) )
		{
			foreach ($tags as $tag => $data) 
			{
				$blockNew = $blockOld;
				$blockNew = str_replace("{{" . $tag . "}}", $data, $blockNew); 
			}
			$block .= $blockNew;
		}
		$pageContent = $this->html->getContent();
		$newContent = str_replace( $blockOld, $block, $pageContent );
		$this->html->setContent( $newContent );
	}

	/**
	 * Get the page object
	 * @return Object 
	 */
	public function getPage()
	{
		return $this->html;
	}

	/**
	 * Set the content of the page based on a number of templates
	 * pass template file locations as individual arguments
	 * @return void
	 */
	public function buildFromTemplates()
	{
		$bits = func_get_args();
		$content = "";
		foreach( $bits as $bit )
		{
			
			if( strpos( $bit, 'skins/' ) === false )
			{
				$bit = APP_PATH . 'skins/' . phpRPGRegistry::getSetting('skin') . '/templates/' . $bit;
			}
			if( file_exists( $bit ) == true )
			{
				$content .= file_get_contents( $bit );
			}
			
		}
		$this->html->setContent( $content );
	}

	/**
	 * Convert an array of data (i.e. a db row?) to some tags
	 * @param array the data 
	 * @param string a prefix which is added to field name to create the tag name
	 * @return void
	 */
	public function dataToTags( $data, $prefix )
	{
		foreach( $data as $key => $content )
		{
			$this->html->addTag( $key.$prefix, $content);
		}
	}

	public function parseTitle()
	{
		$newContent = str_replace('<title>', '<title>'. $this->html->getTitle(), $this->html->getContent() );
		$this->html->setContent( $newContent );
	}

	/**
	 * Parse the page object into some output
	 * @return void
	 */
	public function parseOutput()
	{
		$this->replaceBits();
		$this->replaceTags();
		$this->parseTitle();
	}
}
