<?php

// get data from reddit
$fetchedData = getData();

// sort out html from that data
$html = writeHTML($fetchedData);

// write the html on the page
echo $html;

function getData()
{
	// we'll be returning an object decoded from json
	$redditData = "";

	// determine if there are any special options in the query string param "subs"
	$specialSubreddits = htmlspecialchars($_GET["subs"]);
	
	if ($specialSubreddits)
	{
		// there are special options; url encode them
		$specialSubreddits = urlencode($specialSubreddits);
		$jsonURL = "http://www.reddit.com/r/" . $specialSubreddits . "+/.json";
	}
	else
	{
		// there are no special options; plan on getting everything unfiltered
		$jsonURL = "http://www.reddit.com/r/all/.json";
	}

	// make the request for the appropriate json
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $jsonURL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$redditData = curl_exec($ch);
	curl_close($ch);

	// decode it
	$redditData = json_decode($redditData);

	// return it
	return $redditData;
}

function writeHTML($fetchedData)
{
	// we'll be returning html
	$html = "";

	// validate: is the data we have any good?
	if($fetchedData->data->children)
	{
		// it's good data; loop through all the posts and display them with useful details
		foreach($fetchedData->data->children as $post)
		{
			// identify all the post details
			$title = $post->data->title;
			$url = $post->data->url;
			$subreddit = strtolower($post->data->subreddit);
			$numComments = $post->data->num_comments;
			$commentsLink = $post->data->permalink;

			// determine whether there are comments for this post
			if ($numComments > 0)
			{
				// there are comments; format a link to them
				$comments = '<div class="comments"><a href="http://reddit.com' . $commentsLink . '" target="_blank">' . $numComments . ' comments</a>';
			}
			else
			{
				// there are no comments
				$comments = "";
			}

			// format the post and add it to the html we'll return
			$html .= '<article><h1><a href="' . $url . '" target="_blank">' . $title . '</a></h1><div class="meta"><div class="subreddit">' . $subreddit . '</div>' . $comments . '</div></article>';
		}
	}
	else
	{
		$html = '<div class="error">No valid data was received from Reddit.</div>';
	}

	return $html;
}
?>
