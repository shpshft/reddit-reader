// the variable we'll manipulate when pushing and pulling subs
var config = [];

// get started on page load
initConfig();

// on page load, get the user's preferred subreddits from local storage and display them
function initConfig() {
	if (localStorage['subs']) {
		config = JSON.parse(localStorage['subs']);
	}

	$("#active-subs").empty();

	jQuery.each(config, function() {
		$("#active-subs").prepend('<li><div class="name">' + this + '</div><div class="remove">remove</div></li>');
	});
}

// save the config in local storage
function save()
{
	// take the config in memory and save it to local storage
	localStorage['subs'] = JSON.stringify(config);
	// refresh the ui
	initConfig();
	getContent();
}

// open and close config area
$(document).on("click", "#config-link", function()
{
	$("#config").slideToggle();
	$(this).toggleClass("active");
});

$(document).on("click", "#close-config", function()
{
	$("#config").slideUp();
	$("#config-link").toggleClass("active");
});

// add subreddits
$("#new-sub").keypress(function(e)
{
	if(e.which == 13)
	{
		addSubredditUIEvent();
	}
});

$(document).on("click", "#btn-add-sub", function()
{
		addSubredditUIEvent();
});

// remove subreddits
$(document).on("click", ".remove", function()
{
	var subredditName = $(this).parent().find(".name").text();
	config.splice($.inArray(subredditName,config),1);

	$(this).parent().slideUp(function(){
		save();
	});
});

// ui event helpers
function addSubredditUIEvent()
{
	// get the input
	var subredditName = $("#new-sub input").val();

	if (subredditName)
	{
		// add the line item
		$("#active-subs").prepend('<li style="display:none;" class="new"><div class="name">' + subredditName + '</div><div class="remove">remove</div></li>');

		// slide it in
		$("#active-subs .new").slideDown(function(){
			// clear the input and give it focus
			$("#new-sub input").val("");
			$("#new-sub input").focus();

			// if they put in slashes (e.g. "/r/science" instead of "science"), rip them out
			if(/\//.test(subredditName))
			{
				alert('Slashes (e.g. "/") don\'t belong in subreddit names. We\'ve done our best to guess what you meant.');
				// get everything from the last slash forward
				subredditName = subredditName.substring(subredditName.lastIndexOf("/"));
				// chop off the last slash
				subredditName = subredditName.substring(1);
			}

			// add the subreddit to the config
			config.push(subredditName);

			// save the modified config
			save();
		});
	}
}