<?php include 'header.php'; ?>
<img id="alien" src="images/reddit-alien.png" alt="Reddit" />
<section id="reddit-data" class="page-content"></section>
<script>
	var request = "functions.php?subs=" + localStorage.getItem("subs"); 

	$.get(request, function(data)
	{
		$('#reddit-data').html(data);
	})
	.error(function()
	{
		$('#reddit-data').html('<div class="error">No valid data.</div>');
	});

</script>
<?php include 'footer.php'; ?>
