<?php include 'header.php'; ?>
<section id="config" class="page-content">
	<div id="add-sub">
		<input id="new-sub" placeholder="Add a subreddit by name" />
	</div>
	<ul id="active-subs"></ul>
</section>
<script>
	// on page load, get existing config
	var config = localStorage.getItem("subs");
	if (config)
	{
		config = config.split("+");
		jQuery.each(config, function()
		{
			$("#active-subs").append("<li>" + this + "</li>");
		});
	}

	// when enter is pressed, add the specified subreddit to the config
	$("#new-sub").keypress(function(e)
	{
		if(e.which == 13)
		{
			var newSub = $("#new-sub").val();
			$("#active-subs").append("<li>" + newSub + "</li>");
			save();

			// clear input text
			$("#new-sub").val("");
		}
	});

	// delete subs from config
	$(document).on("click", "#active-subs li", function()
	{
		var confirmDelete = confirm("Remove the subreddit \"" + $(this).text() + "\"?");

		if (confirmDelete == true)
  		{
			$(this).remove();
			save();
		}
	});

	// save the current config
	function save()
	{
		var activeSubs = "";

		$("li").each(function(index)
		{
			if(index > 0)
			{
				activeSubs += "+";
			}

			activeSubs += $(this).text();
		});

		localStorage.setItem("subs", activeSubs);
	}
</script>
<?php include 'footer.php'; ?>
