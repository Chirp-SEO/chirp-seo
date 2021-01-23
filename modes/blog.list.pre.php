<?php
    $HTML = $API->get('HTML');

    $Scores = new ChirpSeo_Scores($API);
    $Keywords = new ChirpSeo_Keywords($API);

    $keywords = array();
    $error = false;
    $message = false;
    $locked = true;

    $Paging->set_per_page(15);

    $keywords = $Keywords->all();

    // Install only if $things is false.
    // This will run the code in activate.php so should only ever happen on first run - silently installing the app.
    if ($keywords == false) {
    	$Keywords->attempt_install();
    }

    $pages = false;

    if (class_exists('PerchBlog_Blogs')) {
      $Posts = new PerchBlog_Posts($API);
      $Posts = $Posts->all($Paging);

      $ScoresForURLs = $Scores->getScoresForPageUrls($Posts, 'postURL');
      $KeywordsForURLs = $Keywords->getKeywordsForPageUrls($Posts, 'postURL');

      foreach($Posts as $Post) {
        $path = $Post->postURL();

        $ChirpListing = new ChirpSeo_Listing();
        $ChirpListing->id = $Post->postID();
        $ChirpListing->path = $path;
        $ChirpListing->title = $Post->postTitle();
        $ChirpListing->readabilityScore = $Scores->getReadabilityScoreForPage($path, $ScoresForURLs);
        $ChirpListing->seoScore = $Scores->getSeoScoreForPage($path, $ScoresForURLs);
        $ChirpListing->keyword = $Keywords->getKeywordForURL($path, $KeywordsForURLs);

        $pages[] = $ChirpListing;
      }
    }

    include('global.list.pre.php');
