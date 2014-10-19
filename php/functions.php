<?php
require_once('TwitterAPIExchange.php');
require_once('TwitterSettings.php');
require_once("simple_html_dom.php");

$feedItems = array();
$itemsByDate = array();


function buildFeeds($feed1, $feed2, $feed3, $feed4){
	
	parserFeed($feed1);
	parseJSON($feed2);
	parserFeed($feed3);
	parserFeed($feed4);
	global $feedItems;
	global $itemsByDate;
	
	krsort($itemsByDate);
	
	foreach($itemsByDate as $key => $val){
		echo $val;
	}
}

/*
 * Parse RSS feed from Tumblr or Select B
 */

function parserFeed($feedURL) {
	global $feedItems;
	global $itemsByDate;
	
	$rss = simplexml_load_file($feedURL);
	$feedTitle = $rss->channel->title;
	$i = 0;
	
	
	foreach ($rss->channel->item as $feedItem) {
		$i++;
		$myDate = ($feedItem->pubDate);
		$dateForm = explode(" ", $myDate);
		$myTimestamp = strtotime($feedItem->pubDate);
		$parentClassName;
		$imageTag;
		$socialTag = "";
		
		//Get the class name depending on if Tumblr or SelectB
		if($feedTitle == "Bunmblr"){ $parentClassName = "tumblr"; $socialTag = "<span class='socialIcon'>T</span>";}
		elseif($feedTitle == "Select B") {$parentClassName = "selectB"; $socialTag = "<span class='socialIcon'>w</span>";}
		
		//Get the HTML content of post
		$itemContent = $feedItem->description;
		
		//Get Photo from content
		$html = str_get_html($itemContent);
		$imageTag = $html->find('img', 0);
		$imageURL = $imageTag->src;
		$videoTag = $html->find('object', 0);
		

		//Add HTML format to $itemFormat
		
		$itemFormat = "";
		if($imageTag){ //If content contains and image, set as background image
			$itemFormat .= "<div style='background: url($imageURL); background-position: center;' class='rssItem photo $parentClassName' data-date='$myTimestamp' data-img='$imageURL'>";
		}
		elseif($videoTag){
			$itemFormat .= "<div class='rssItem video $parentClassName' data-date='$myTimestamp' data-img='$imageURL'>";
		}
		else{ //If there's no image
			$itemFormat .= "<div class='rssItem $parentClassName' data-date='$myTimestamp'>";
		}
		
		
		$itemFormat .= "<div><a href='$feedItem->link' title='$feedItem->title'><h4 class='itemTitle'> $feedItem->title</h4><div class='itemContent'></div></a><h5 class='itemDate'>".date("m/d/Y",$myTimestamp)."</h5>
		<h5 class='itemPosted'>Posted ".howLongAgo($myTimestamp)."</h5>
		<h6 class='itemFeedTitle'>$feedTitle</h6></div>$socialTag</div>";
		
		//Add to Array
		array_push($feedItems, $itemFormat);
		$itemsByDate[$myTimestamp] = $itemFormat;
		
		if($i >= 3) break;
	}
	
}

/*
 * Parse JSON feed (from Twitter)
 */

function parseJSON($feedURL){
   	
   	global $twitterJSON;
   	global $feedItems;
   	global $itemsByDate;
   	
	$json_a = json_decode($twitterJSON, true);	
	
	for($i=0; $i <=2; $i++)
	{
		$tweettime = $json_a[$i]['created_at'];
		$tweetURL = $json_a[$i]['id_str'];
		$tweetLink = $json_a[$i][entities]['urls']['url'];
		$datetime = new DateTime($tweettime);
		$Tweet_timestamp = $datetime->format('U');
		$Tweet_text = $json_a[$i]['text'];
		/*$Tweet_linkified = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $Tweet_text);*/
		
		$itemFormat = "<div class='rssItem twitter'><div class='tweetContent'><p>".$Tweet_text."</p><div class='itemInfo'><span class='created_by'>".$json_a[$i][user]['name']." </span><span class='posted'>posted ".howLongAgo($Tweet_timestamp)."</span></div><span class='socialIcon'><a href='http://www.twitter.com/bunmun/status/$tweetURL'>t</a>​</span></div></div>";

		array_push($feedItems, $itemFormat);
		$itemsByDate[$Tweet_timestamp] = $itemFormat;
	}	
	//var_dump($json_a);
}

/*
 * Parse RSS feed
 */
 
function parser($feedURL) {
	$rss = simplexml_load_file($feedURL);
	$feedTitle = $rss->channel->title;
	echo "<ul class='news'>";
	$i = 0;
	foreach ($rss->channel->item as $feedItem) {
		$i++;
		$myDate = ($feedItem->pubDate);
		$dateForm = explode(" ", $myDate);
		echo "<li>
			<h2 class='news'><a href='$feedItem->link' title='$feedItem->title'>" . $feedItem->title . "</a></h2>
			<p class='desc'>" . $feedItem->description . "</p>
			<p class='date'>Posted on: " . $dateForm[1] . ". " . $dateForm[2] . ". " . $dateForm[3] . "." . "<a class='cont' href='$feedItem->link' title='$feedItem->title'>Continue Reading</a></p>
		</li>";
		if($i >= 5) break;
	}
	echo "</ul>";
}

/*
 * Convert timestamp to "when" it was posted
 */
 
function howLongAgo($timestamp){
	
	$diff = time()-$timestamp;
	$day_diff = floor($diff/86400);
	$timeString = "";
	
	if(is_nan($day_diff) || $day_diff < 0 || $day_diff>365) $timeString = "Over a year ago";
	
	if($day_diff > 0){
			if($diff < 60) $timeString = "just now";
			elseif($diff < 120) $timeString = "1 minute ago";
			elseif($diff < 3600) $timeString = floor($diff/60)." minutes ago";
			elseif($diff < 7200) $timeString = "1 hour ago";
			elseif($diff < 86400) $timeString = floor($diff/3600)." hours ago";
			elseif($day_diff == 1) $timeString = "Yesterday";
			elseif($day_diff < 7) $timeString = $day_diff." days ago";
			elseif($day_diff <31) $timeString = ceil($day_diff/7)." weeks ago";
			elseif($day_diff < 365) $timeString = ceil($day_diff/30)." months ago";
			elseif($day_diff < 540 && $day_diff > 365) $timeString = ceil($day_diff/30)." months ago";
			elseif($day_diff > 540) $timeString = ceil($day_diff/365)." years ago";
	}
	
	return $timeString;
	
}
