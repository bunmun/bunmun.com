<?php
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "14160693-OJXs3jSKYWuvBLgAl5tW9fauPDlo1c27GMR6Euzru",
    'oauth_access_token_secret' => "sIhaRqJZOqHR9lI44OYHUNGzWExUMovmp7O0Jv2dXs",
    'consumer_key' => "y7lZ0jWHJltfZguDVqGA",
    'consumer_secret' => "0YayXZwMjms7AX1MwzDcTjQlK5dAS2wCr8NhyJjRYTU"
);

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=bunmun&count=3';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$twitterJSON = $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

?>
