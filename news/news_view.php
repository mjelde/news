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


<h3><?=$myFeed->FeedName;?></h3>

<?php

if($myFeed->isValid) { # check to see if we have a valid FeedID
	echo '<p>' . $myFeed->FeedDescription . '</p>';

	echo '	
		<table class="table table-hover">
			<thead>
				<tr>
					<th scope="col">Feed Category</th>
				</tr>
			</thead>
			<tbody>  
	';

	echo $myFeed->showCategories();

	echo '
			</tbody>
		</table>	
	';


} else {
	echo "Sorry, no such feed!";	
}

get_footer(); # defaults to theme footer or footer_inc.php
