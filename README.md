# Views of VGM

Official website for Views of VGM (podcast, Instagram, VGMStudios apps). Static site: open index.html.

- Embed Instagram posts: add links to INSTAGRAM_POSTS in index.html.
- Play Store links: update APPS[].url in index.html.
- Host photo: assets/host.jpg


## Category slideshows
Each category in `CATEGORIES` (index.html) has an Instagram highlight link and a `posts` list
(`"p/POSTID"` or `"reel/REELID"`, newest first) shown in the on-site slideshow.

## Live follower count
`api/followers.php` (PHP) returns the follower count from the official Instagram Graph API.
Copy `api/config.example.php` to `api/config.php` and set `IG_USER_ID` and `IG_ACCESS_TOKEN`
(needs a Business/Creator Instagram account linked to a Facebook Page). Until then the page shows
`FOLLOWERS_FALLBACK` from index.html.
