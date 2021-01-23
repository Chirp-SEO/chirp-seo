<?php
    $HTML = $API->get('HTML');

    $Scores = new ChirpSeo_Scores($API);
    $Keywords = new ChirpSeo_Keywords($API);

    $keywords = array();

    $keywords = $Keywords->all();

    // Install only if $things is false.
    // This will run the code in activate.php so should only ever happen on first run - silently installing the app.
    if ($keywords == false) {
    	$Keywords->attempt_install();
    }

    $collectionID = (int)PerchUtil::get('id');

    $pages = false;

    if (PERCH_RUNWAY) {
      $Collections = new PerchContent_Collections();
      $Collection = $Collections->find($collectionID);

      $AllItems = $Collection->get_items_for_editing(false, $Paging);

      $ScoresForURLs = $Scores->getScoresForPageUrls($AllItems, 'collection', $Collection);
      $KeywordsForURLs = $Keywords->getKeywordsForPageUrls($AllItems, 'collection', $Collection);

      $pages = array();

      foreach($AllItems as $Item) {
        $path = ChirpSeo_Util::get_page_path_from_collection($Collection, $Item["itemID"]);

        $ChirpListing = new ChirpSeo_Listing();
        $ChirpListing->id = $Item["itemID"] . '&collection=' . $Item["collectionID"];
        $ChirpListing->path = $path;
        $ChirpListing->title = ChirpSeo_Util::get_title_for_collection_item($Item);
        $ChirpListing->readabilityScore = $Scores->getReadabilityScoreForPage($path, $ScoresForURLs);
        $ChirpListing->seoScore = $Scores->getSeoScoreForPage($path, $ScoresForURLs);
        $ChirpListing->keyword = $Keywords->getKeywordForURL($path, $KeywordsForURLs);

        $pages[] = $ChirpListing;
      }
    }

    include('global.list.pre.php');