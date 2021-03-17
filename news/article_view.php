<?php
/**
 * news_view.php is a page to demonstrate the proof of concept of the 
 * initial News objects.
 *
 * Objects in this version are the Feed and FeedCategory objects
 * 
 * @package News
 * @author Sharon Alexander, Kira Abell, Ti Hall <group1@example.com>
 * @version 1.5 2021/03/13
 * @link http://www.example.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see Feed.php
 * @see Category.php
 */
 
require '../inc_0700/config_inc.php'; # provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader'); //required to load News namespace objects
$config->metaRobots = 'no index, no follow'; # never index feed pages

// adds font awesome icons for arrows on pager
$config->loadhead .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';

$sql = "select c.FeedCategoryID, c.CategoryName, c.CategoryURL from " . PREFIX . "feed_categories c";

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0) { # roper data must be on querystring
	 $myID = (int)$_GET['id']; # Convert to integer, will equate to zero if fails
} else {
	myRedirect(VIRTUAL_PATH . "news/index.php");
}

$myFeed = new News\Feed($myID); //MY_Feed extends feed class so methods can be added
if($myFeed->isValid) {
	$config->titleTag = "$myFeed->FeedName Feed!";
} else {
	$config->titleTag = smartTitle(); //use constant 
}

#END CONFIG AREA ---------------------------------------------------------- 

get_header(); # defaults to theme header or header_inc.php
?>


<?php	

# reference images for pager
//$prev = '<img src="' . $config->virtual_path . '/images/arrow_prev.gif" border="0" />';
//$next = '<img src="' . $config->virtual_path . '/images/arrow_next.gif" border="0" />';

# images in this case are from font awesome
$prev = '<i class="fa fa-chevron-circle-left"></i>';
$next = '<i class="fa fa-chevron-circle-right"></i>';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0) {

	if($myPager->showTotal()==1) {
		$itemz = "Article";
	} else {
		$itemz = "Articles";
	} // deal with plural
	
	while( $row = mysqli_fetch_assoc($result) ) {

		if( dbOut($row['FeedCategoryID']) == $myID ) {

			echo '

				<h3>'. dbOut($row['CategoryName']) .'</h3>

				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Article Title</th>
							<th class="news-date" scope="col">Date</th>
						</tr>
					</thead>
					<tbody>  
			';
	
			$url = strval( dbOut($row['CategoryURL']) );
			$content = file_get_contents($url);
			$xml = simplexml_load_string($content);
	
			foreach($xml->channel->item as $story) {
	
				echo '
					<tr>
						<td><a href="'. $story->link .'">'. $story->title .'</a></td>	
						<td>'. date( "F j, Y", strtotime($story->pubDate) ) .'</td>
					</tr>
				';	
	
			}

			echo '
					</tbody>
				</table>
			';
	
		}
	
	}

	echo $myPager->showNAV(); # show paging nav, only if enough records

} else { # no records

	echo "<div align=center>What! No muffins? There must be a mistake!!</div>";

}

@mysqli_free_result($result);


get_footer(); # defaults to theme footer or footer_inc.php
