<?php
// Feed.php
namespace News;

/**
 * Feed Class retrieves data info for an individual Feed
 * 
 * The constructor an instance of the Feed class creates multiple instances of the 
 * Category class to store categories from the DB.
 *
 * Properties of the Feed class like FeedName, FeedDescription and TotalCategories provide 
 * summary information upon demand.
 * 
 * A feed object (an instance of the Feed class) can be created in this manner:
 *
 *<code>
 *$myFeed = new News\Feed(1);
 *</code>
 *
 * In which one is the number of a valid Feed in the database. 
 *
 * The forward slash in front of IDB picks up the global namespace, which is required 
 * now that we're here inside the News namespace: \IDB::conn()
 *
 * The showCategories() method of the Feed object created will access an array of category 
 * objects to produce the visible data.
 *
 * @see Category
 * @todo none
 */
 
class Feed {
	public $FeedID = 0;
	public $FeedName = "";
	public $FeedDescription = "";
	public $isValid = FALSE;
	public $TotalCategories = 0; # stores number of categories
	protected $aCategory = Array(); # stores an array of category objects
	
	/**
	 * Constructor for Feed class. 
	 *
	 * @param integer $id The unique ID number of the Feed
	 * @return void 
	 * @todo none
	 */

    function __construct($id) { # constructor sets stage by adding data to an instance of the object

		$this->FeedID = (int)$id;
		if($this->FeedID == 0) {
			return FALSE;
		}
		
		# get Feed data from DB
		$sql = sprintf("select FeedName, FeedDescription from " . PREFIX . "feeds Where FeedID =%d", $this->FeedID); // %d is only string that looks like integer
		
		# in mysqli, connection and query are reversed!  connection comes first
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0) { # Must be a valid feed!
			$this->isValid = TRUE;

			while ( $row = mysqli_fetch_assoc($result) ) { # dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			     $this->FeedName = dbOut($row['FeedName']);
			     $this->FeedDescription = dbOut($row['FeedDescription']);
			}
		}
		@mysqli_free_result($result); # free resources
		
		if(!$this->isValid) {
			return;
		} # exit, as Feed is not valid
		

		# attempt to create category objects
		$sql = sprintf("select FeedCategoryID, CategoryName, CategoryURL from " . PREFIX . "feed_categories where FeedID =%d", $this->FeedID);
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));
		if (mysqli_num_rows($result) > 0) { # show results

			while ( $row = mysqli_fetch_assoc($result) ) {
				# create category, and push onto stack!
				$this->aCategory[] = new Category( dbOut($row['FeedCategoryID']),dbOut($row['CategoryName']),dbOut($row['CategoryURL']) );
			}
		}
		$this->TotalCategories = count($this->aCategory); // the count of the aQuestion array is the total number of categories
		@mysqli_free_result($result); # free resources		

	} # end Feed() constructor
	

	/**
	 * Reveals categories in internal Array of Category Objects 
	 *
	 * @param none
	 * @return string prints data from Category Array 
	 * @todo none
	 */

	function showCategories() {
		$myReturn = '';

		if($this->TotalCategories > 0) { # be certain there are categories

			foreach($this->aCategory as $category) { # print data for each
				$myReturn .= '
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">' . $category->CategoryName . '</h3>
						</div>
						<div class="panel-body">
							<a href="' . $category->CategoryURL . '">' . $category->CategoryURL . '</a>						
						</div>
					</div>
				';

				// echo $category->FeedCategoryID . " ";
				// echo $category->CategoryName . " ";
				// echo $category->CategoryURL . "<br />";

			}

		} else {
			$myReturn .= "There are currently no categories for this feed.";	
		}
		return $myReturn;

	} # end showCategories() method

} # end Feed class
