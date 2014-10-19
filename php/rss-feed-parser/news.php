<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>News | Fictive Company</title>
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
				<h1>Company News</h1>
				<?php parser("http://feeds.feedburner.com/onextrapixel"); ?>
			</div>
		</div>
	</div>

	<div id="sidebar">
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

<div class="container">
	<div id="footer">
		<p id="copyright">Copyright © 2009. by <strong>Fictive Company</strong>. All Rights Reserved.</p>
	</div>
</div>

</body>
</html>