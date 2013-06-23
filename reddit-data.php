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
			$jsonURL = "http://www.reddit.com/r/" . $specialSubreddits . "+/.json";
		}
		else
		{
			// there are no special options; get my default subs
			$jsonURL = "http://www.reddit.com/r/all/.json";
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
		if(/.jpg$/.test(post.url)
				|| /.jpeg$/.test(post.url)
				|| /.gif$/.test(post.url)
				|| /.png$/.test(post.url)){
			preview = '<img src="' + post.url + '" alt="preview" class="preview-image" />';
		}
		else if(/imgur.com/.test(post.url)){
			if(/\/a\//.test(post.url) || /gallery/.test(post.url)){
				preview = "";
			}
			else{
				preview = post.url;
				preview = preview.replace("http://","");
				preview = preview.replace("www.","");
				preview = "http://i." + preview + ".jpg";
				preview = '<img src="' + preview + '" alt="preview" class="preview-image built-from-imgur" />';
			}

		}
		else{
			preview = '';
		}

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
</script>