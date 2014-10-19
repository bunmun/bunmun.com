<?php
require_once('../TwitterAPIExchange.php');
require_once('../TwitterSettings.php');

function parserFeed($feedURL) {
	$rss = simplexml_load_file($feedURL);
	$feedTitle = $rss->channel->title;
	echo "<div class='newsSide'>";
	$i = 0;
	foreach ($rss->channel->item as $feedItem) {
		$i++;
		$myDate = ($feedItem->pubDate);
		$dateForm = explode(" ", $myDate);
		echo "<div><a href='$feedItem->link' title='$feedItem->title'>" . $feedItem->title . "</a><h5>".date("m/d/Y",strtotime($feedItem->pubDate))."</h5>
		<h5>".howLongAgo(strtotime($feedItem->pubDate))."</h5>
		<h6>".$feedTitle."</h6></div>";
		if($i >= 5) break;
	}
	echo "</div>";
}

function parseJSON($feedURL){
   	
   	global $twitterJSON;
   	
	$json_a = json_decode($twitterJSON, true);	
	
	for($i=0; $i <=2; $i++)
	{
		echo "<br />".$json_a[$i][user]['name'];
		echo "<br />".$json_a[$i]['text'];
		$tweettime = $json_a[$i]['created_at'];
		$tweetURL = $json_a[$i]['id_str'];
		$tweetLink = $json_a[$i][entities]['urls']['url'];
		$datetime = new DateTime($tweettime);
		$Tweet_timestamp = $datetime->format('U');
		echo "<br />Posted: ".howLongAgo($Tweet_timestamp);
		echo "<br />Link: <a href='http://twitter.com/bunmun/status/".$tweetURL."'>Link To Tweet</a>";
		echo "<br />";
	}	
	//var_dump($json_a);
}


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

function howLongAgo($timestamp){
	
	$diff = time()-$timestamp;
	$day_diff = floor($diff/86400);
	$timeString = "";
	
	echo "<script>console.log('The timestamp: ".$timestamp." The diff: ".$day_diff."')</script>";
	
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
