# Chirp SEO
Chirp allows Perch content editors to analyse their content, and improve their on-site SEO.

## Installation
To install Chirp, simply download the latest release, rename the folder to `chirp_seo` and add the folder to your Perch addons/apps folder (eg: perch/addons/apps), and huzzah, it’s installed!

## What version of Perch does Chirp support?
Chirp works on both Perch 3, and Perch Runway 3.

## If you're getting an error...
Chirp’s parser requires some features to allow us to crawl your site. We can use either cURL or PHP stream handler.

To use the cURL handler, you must have a recent version of cURL >= 7.19.4 compiled with OpenSSL and zlib.
To use the PHP stream handler, allow_url_fopen must be enabled in your system’s php.ini.
(Contact your web host, they’ll be able to help!)

If this doesn't work, please create a new issue.
