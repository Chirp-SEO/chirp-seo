<?php
    $Pages      = new PerchContent_Pages;
    $Scores = new ChirpSeo_Scores($API);
    $Keywords = new ChirpSeo_Keywords($API);

    $HTML = $API->get('HTML');

    $Paging->set_per_page(15);
    $editLink = 'content/view';

    $AllPages = $Pages->get_by('pageHidden', '', 'pageTreePosition', $Paging);
    $ScoresForURLs = $Scores->getScoresForPageUrls($AllPages, 'pagePath');
    $KeywordsForURLs = $Keywords->getKeywordsForPageUrls($AllPages, 'pagePath');

    $pages = array();

    foreach($AllPages as $Page) {
      $path = $Page->pagePath();

      $ChirpListing = new ChirpSeo_Listing();
      $ChirpListing->id = $Page->pageID();
      $ChirpListing->path = $path;
      $ChirpListing->title = $Page->pageNavText();
      $ChirpListing->readabilityScore = $Scores->getReadabilityScoreForPage($path, $ScoresForURLs);
      $ChirpListing->seoScore = $Scores->getSeoScoreForPage($path, $ScoresForURLs);
      $ChirpListing->keyword = $Keywords->getKeywordForURL($path, $KeywordsForURLs);

      $pages[] = $ChirpListing;
    }

    include('global.list.pre.php');