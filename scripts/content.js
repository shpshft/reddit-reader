// we're about to request reddit data
var request = "reddit-data.php";

// check for preferred subreddits
if (localStorage.getItem("subs"))
{
	request = request + "?subs=" + JSON.parse(localStorage.getItem("subs")).toString().replace(/,/g,"+");
}

// make the call
$.get(request, function(data)
{
	$('#reddit-data').html(data);
})
.error(function()
{
	$('#reddit-data').html('<div class="error">No valid data.</div>');
});
