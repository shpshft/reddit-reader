<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1" />
		<meta name="description" content="A simplified reader." />
		<meta name="author" content="Daniel Delaney" />
		<title>Reddit</title>
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" href="images/favicon.png" />
		<link rel="apple-touch-icon" href="images/favicon.png" />
	</head>
	<body>
		<header>
			<hgroup>
				<h1><a href="http://danieldelaney.net/r/">reddit</a></h1>
				<h2>a simplified reader</h2>
			</hgroup>
		</header>
		<a href="http://danieldelaney.net/r/" id="alien">
			<img src="images/reddit-alien.png" alt="Reddit" />
		</a>
		<section id="reddit-data">
			<?php
				include 'functions.php';
				generateContent();
			?>
		</section>
		<footer>
			Made by <a href="http://danieldelaney.net/" target="_blank">Daniel Delaney</a>
		</footer>
	</body>
</html>