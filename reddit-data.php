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
			$jsonURL = "http://www.reddit.com/r/" . $specialSubreddits . "+/.json?limit=30";
		}
		else
		{
			// there are no special options; get my default subs
			$jsonURL = "http://www.reddit.com/r/all/.json?limit=30";
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
	// keep track of how many we've written to the page
	var postCount = 0;
	// build html
	var html = '';
	// loop through it
	$.each(redditData.data.children,function(key,val){
		// define the post root
		var post = val.data;

		// check for images to display
		var preview = buildPreview(post.url);

		// spit out html
		if (postCount == 0){
			html = html + '<div class="col-lg-4">';
		}
		
		html = html +
			'<article class="panel">' +
				'<h4 class="title">' +
					'<a href="' + post.url + '" target="_blank">' +
						post.title +
					'</a>' +
				'</h4>' +
				preview +
				'<div class="meta panel-footer">' +
					'<div class="subreddit pull-left text-muted">' + post.subreddit + '</div>' +
					'<div class="comments pull-right">' +
						'<a href="http://reddit.com' + post.permalink + '" target="_blank">' +
							post.num_comments + ' comments' +
						'</a>' +
					'</div>' +
				'</div>' +
			'</article>';
			
		// increment post count
		postCount = postCount + 1;
		if (postCount == 10 || postCount == 20){
			html = html + '</div><div class="col-lg-4">';
		}
	});
	
	$("#result").append(html);

	function buildPreview(url)
	{
		preview = '';
		var isImage = false;
		var origin = '';

		// check for image
		if(/.jpg$/.test(url) || /.jpeg$/.test(url) || /.gif$/.test(url) || /.png$/.test(url)){
			isImage = true;
			origin = 'clean-ext';
		} else if (/imgur.com/.test(url) && !/\/a\//.test(url) && !/gallery/.test(url)) {
			// check for incorrectly linked image and correct
			url = url.replace("http://","");
			url = url.replace("www.","");
			url = "http://i." + url + ".jpg";
			isImage = true;
			origin = 'imgur-single-hack';
		} else if (/imgur.com/.test(url) && /\/a\//.test(url)) {
			preview = '<iframe class="imgur-album" frameborder="0" src="' + url + '/embed"></iframe>';
		}

		if (isImage){
			preview = '<img src="' + url + '" alt="preview" class="preview-image ' + origin + '" />';
		}

		return preview;
	}
</script>
