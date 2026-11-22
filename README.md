# Views of VGM

Official website for Views of VGM (podcast, Instagram, VGMStudios apps). Static site: open index.html.

- Embed Instagram posts: add links to INSTAGRAM_POSTS in index.html.
- Play Store links: update APPS[].url in index.html.
- Host photo: assets/host.jpg


## Category slideshows
Each category in `CATEGORIES` (index.html) has an Instagram highlight link and a `posts` list
(`"p/POSTID"` or `"reel/REELID"`, newest first) shown in the on-site slideshow.

## Follower count
`data/stats.json` holds the follower count. The page reads it fresh on every refresh. A daily scheduled
task updates it (and adds new posts to categories) and pushes. No backend needed: the site is static files.
