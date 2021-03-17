<?php
// Category.php
namespace News;

class Category {
	
	public $FeedCategoryID = 0;
	public $CategoryName = "";
	public $CategoryURL = "";

	/**
	 * Constructor for Category class. 
	 *
	 * @param integer $id ID number of category
	 * @param string $name The name of the category
	 * @param string $url The url for the rss feed
	 * @return void 
     * @todo none
	 */

    function __construct($id, $name, $url) { # constructor sets stage by adding data to an instance of the object
		$this->FeedCategoryID = (int)$id;
		$this->CategoryName = $name;
		$this->CategoryURL = $url;
	} # end Category() constructor
	
} # end Category class
