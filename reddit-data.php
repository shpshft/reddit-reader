<div id="result">
	<?php
		// we'll be returning an object decoded from json
		$redditData = "";

		// determine if there are any special options in the query string param "subs"
		$specialSubreddits = htmlspecialchars($_GET["subs"]);

		if ($specialSubreddits)
		{
			// there are special options; url encode them
			$specialSubreddits = urlencode($specialSubreddits);
			$jsonURL = "http://www.reddit.com/r/" . $specialSubreddits . "+/.json?limit=100";
		}
		else
		{
			// there are no special options; get my default subs
			$jsonURL = "http://www.reddit.com/r/all/.json?limit=100";
		}

		// make the request for the appropriate json
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $jsonURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$redditData = curl_exec($ch);
		curl_close($ch);

		// write it
		print_r($redditData);
	?>
</div>
<script>
	// json is assumed to be present thanks to server-side code
	// pull json from html
	var redditData = $("#result").html();
	// clear out the html
	$("#result").html('');
	// make it readable
	redditData = $.parseJSON(redditData);
	// loop through it
	$.each(redditData.data.children,function(key,val){
		// define the post root
		var post = val.data;

		// check for images to display
		var preview = buildPreview(post.url);

		// spit out html
		var html =
			'<article>' +
				'<h1>' +
					'<a href="' + post.url + '" target="_blank">' +
						post.title +
					'</a>' +
				'</h1>' +
				preview +
				'<div class="meta">' +
					'<div class="subreddit">' + post.subreddit + '</div>' +
					'<div class="comments">' +
						'<a href="http://reddit.com' + post.permalink + '" target="_blank">' +
							post.num_comments + ' comments' +
						'</a>' +
					'</div>' +
				'</div>' +
			'</article>';
		$("#result").append(html);
	});

	function buildPreview(url)
	{
		// if it ends with an image filetype, throw it in an img tag
		if(/.jpg$/.test(url)
				|| /.jpeg$/.test(url)
				|| /.gif$/.test(url)
				|| /.png$/.test(url)){
			preview = '<img src="' + url + '" alt="preview" class="preview-image" />';
		}
		else if(/imgur.com/.test(url)){
			// if it's an imgur gallery, give up
			if(/\/a\//.test(url) || /gallery/.test(url)){
				preview = "";
			}
			// if it's from imgur,
			// not a gallery,
			// and not an image,
			// they posted it wrong, fix it to be an image
			else{
				preview = url;
				preview = preview.replace("http://","");
				preview = preview.replace("www.","");
				preview = "http://i." + preview + ".jpg";
				preview = '<img src="' + preview + '" alt="preview" class="preview-image built-from-imgur" />';
			}

		}
		else{
			preview = '';
		}

		return preview;
	}
</script>