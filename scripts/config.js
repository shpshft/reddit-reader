// on page load, get the user's preferred subreddits from local storage and display them
var config = [];

if (localStorage['subs'])
{
	config = JSON.parse(localStorage['subs']);
}

generateList();

// display the active subreddits 
function generateList()
{
	$("#active-subs").empty();

	jQuery.each(config, function()
	{
		$("#active-subs").append('<li><div class="name">' + this + '</div><div class="remove">remove</div></li>');
	});
}

// add and subtract subreddits from local storage
function addSubreddit(subredditName)
{
	config.push(subredditName);
	save();
}

function removeSubreddit(subredditName)
{
	config.splice($.inArray(subredditName,config),1);
	save();
}

function save()
{
	localStorage['subs'] = JSON.stringify(config);
	generateList();
}

// handle ui events which initiate addition and subtraction of subreddits
$("#new-sub").keypress(function(e)
{
	if(e.which == 13)
	{
		var subredditName = $("#new-sub").val();
		addSubreddit(subredditName);
		$("#new-sub").val("");
	}
});

$(document).on("click", ".remove", function()
{
	var subredditName = $(this).parent().find(".name").text();
	removeSubreddit(subredditName); 
});
