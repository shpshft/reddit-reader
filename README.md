# Reddit Reader

A minimal view of Reddit content. See it in action here:

http://danieldelaney.net/r/

# How it Works

At first it shows the default subreddits, but you can easily choose which subs you'd like to see content from.

Images that normally break RES (linking to an Imgur page rather than the actual image, etc.) are magically fetched regardless.

PHP is used to fetch data from Reddit's JSON API, and JavaScript manages locally stored preferences as well as data flying on and off of the page.