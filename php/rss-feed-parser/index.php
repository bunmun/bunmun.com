<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Fictive Company</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>

<body>
<div id='zero'><?php require_once "functions.php"; ?></div>
<div class="container">
	<ul id="nav">
		<li><a href="index.php">Home</a></li>
		<li><a href="news.php">News</a></li>
	</ul>
</div>

<div id="header">
	<div class="container">
		<a id="logo" href="index.php">Fictive Company</a>
	</div>
</div>

<div class="container">
	<div id="main">
		<div class="central">
			<div class="box">
				<h1>Welcome to the Fictive Company Website</h1>
				<p>Curabitur ut congue hac, diam turpis maecenas id vestibulum nulla nisl, libero leo, ut scelerisque maecenas id, ornare magna orci. In blandit sed et sagittis non, ullamcorper nec metus felis vel, vestibulum a in sit. Leo non odio fermentum lectus cubilia, mauris aliquam nunc eu neque ac sollicitudin. Tincidunt nisl morbi nulla rutrum, adipisicing tellus integer nunc massa id quis. Cursus sagittis massa ac sociis interdum, sem cursus, enim aptent sit, semper mauris, quam urna sed quis vivamus.</p>
				<p>Tortor et diam, dictumst lacinia sed, non adipiscing pulvinar nunc nec, habitasse nunc urna urna. Sollicitudin auctor, arcu tincidunt ut suspendisse nulla, ipsum vel blandit urna metus pharetra nulla. Ultricies dolor ut, proin dolor leo, non dolor, morbi ipsum tempor rhoncus, pede turpis morbi. Id convallis, per sem ornare magnis, in malesuada ridiculus, quam scelerisque vestibulum arcu magna volutpat arcu.</p>
				<p>Placerat massa etiam laoreet venenatis turpis non. Donec nullam pharetra ut, sed consectetuer, vulputate non nec eu donec consectetuer tempus, commodo fusce morbi tellus orci et officia, at sapien interdum duis sem et aptent. Non sodales. Dolor eros, nec vitae in ligula venenatis lacus, vel fermentum massa. Urna felis ornare metus quis aliquam nec, enim mattis, proin id nec, fringilla eget dapibus, eget suscipit ac dolor in. Nunc dui, libero adipiscing sodales porta, suscipit nulla ornare sed malesuada, interdum nibh eget rutrum rutrum ac. Ut pellentesque. Adipiscing est dis diam vestibulum, irure quis sed.</p>
			</div>
		</div>

		<div id="sidebar">
			<div class="box">
				<h2>News Feed</h2>
				<?php 
				parserFeed("http://www.selectb.com/feed/");
					
				 ?>
				 <h2>Twitter Feed</h2>
				 <?php parseJSON("../Bunmun_Foundation/php/TwitterSettings.php");?>
				 
				 <h2>Tumblr</h2>
				 <?php parserFeed("http://bunmblr.selectb.com/rss"); ?>
			</div>
	
			<div class="box">
				<h2>Blogroll</h2>
				<ul class="blogroll">
					<li><a href="http://www.onextrapixel.com/">Onextrapixel</a></li>
					<li><a href="http://10steps.sg/">10Steps.SG</a></li>
					<li><a href="http://www.csswebsites.nl/">CSS Websites</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div id="footer">
		<p id="copyright">Copyright © 2009. by <strong>Fictive Company</strong>. All Rights Reserved.</p>
	</div>
</div>

</body>
</html>