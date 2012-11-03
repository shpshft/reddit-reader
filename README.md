# Reddit Reader

A minimalist view of Reddit content. See it in action here:

http://danieldelaney.net/reddit-reader/

## How it works

Pulls JSON (e.g. http://reddit.com/r/all/.json) and spits out HTML, all via PHP.

## How to use it

By default it'll show the contents of /r/all (http://reddit.com/r/all/.json), but you can specify subreddits you want to see with the query string parameter "subs", like so:

http://danieldelaney.net/reddit-reader/?subs=programming

You can specify multiple subreddits at a time this way:

http://danieldelaney.net/reddit-reader/?subs=programming+design+technology

This is a hack until I invent a decent subreddit selection system.