<?php include 'header.php'; ?>
<img id="alien" src="images/reddit-alien.png" alt="Reddit" />
<section id="reddit-data" class="page-content">
	<?php include 'functions.php'; ?>
</section>
<script>
	var subs = getUrlVars()["subs"]
	var config = localStorage.getItem("subs");
	if (config != subs)
	{
		window.location = "./?subs=" + config;
	}

	function getUrlVars()
	{
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	    }
	    return vars;
	}
</script>
<?php include 'footer.php'; ?>
