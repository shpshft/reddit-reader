// initialise subreddit configuration
var config = [];
initConfig();
function initConfig() {
	// empty subreddit list
	$("#active-subs").empty();
	// populate subreddit list with what's in local storage
	if (localStorage['subs']) {
		config = JSON.parse(localStorage['subs']);
		jQuery.each(config, function() {
			$("#active-subs").prepend('<li class="list-group-item"><span class="name">' + this + '</span><a class="remove pull-right" href="#"><i class="icon-remove-sign"></i></a></li>');
		});
	}
	// set up event handlers
	$(document).on("click", "#config-link", function(){
		event.preventDefault();
		$("html,body").animate({scrollTop:0},"slow");
		$("#config").slideToggle();
	});
	$("#new-sub-input").keypress(function(e){
		if(e.which == 13){
			// the return key was pressed
			addSubredditUIEvent();
		}
	});
	$(document).on("click", "#new-sub-button", function(){
			event.preventDefault();
			addSubredditUIEvent();
	});
	$(document).on("click", ".remove", function(){
			event.preventDefault();
			removeSubredditUIEvent($(this));
	});
}
// add, remove, and save subreddit configuration
function addSubredditUIEvent(){
	var subredditName = $("#new-sub-input").val();
	$("#new-sub-input").val("");
	$("#new-sub-input").focus();
	if (subredditName){
		$("#active-subs").prepend('<li style="display:none;" class="new list-group-item"><span class="name">' + subredditName + '</span><a class="remove pull-right" href="#"><i class="icon-remove-sign"></i></a></li>');
		$("#active-subs .new").slideDown(function(){
			$("#active-subs .new").removeClass("new");
			if(/\//.test(subredditName)){
				alert('Slashes (e.g. "/") don\'t belong in subreddit names. We\'ve done our best to guess what you meant.');
				subredditName = subredditName.substring(subredditName.lastIndexOf("/"));
				subredditName = subredditName.substring(1);
			}
		});
		config.push(subredditName);
		save();
	}
}
function removeSubredditUIEvent(removeButton){
	var subredditName = removeButton.parent().find(".name").text();
	config.splice($.inArray(subredditName,config),1);
	removeButton.parent().slideUp(function(){
		save();
	});
}
function save() {
	localStorage['subs'] = JSON.stringify(config);
	getContent();
}