<?php
    $HTML = $API->get('HTML');

    $Keywords = new ChirpSeo_Keywords($API);
    $Scores = new ChirpSeo_Scores($API);

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

    if (class_exists('PerchShop_Products')) {
      $Products = new PerchShop_Products($API);
      $AllProducts = $Products->all($Paging);

      $ScoresForURLs = $Scores->getScoresForPageUrls($AllProducts, 'shop');
      $KeywordsForURLs = $Keywords->getKeywordsForPageUrls($AllProducts, 'shop');

      $pages = array();

      foreach($AllProducts as $Product) {
        $path = ChirpSeo_Util::get_product_url($Product);

        $ChirpListing = new ChirpSeo_Listing();
        $ChirpListing->id = $Product->productID();
        $ChirpListing->path = $path;
        $ChirpListing->title = $Product->title();
        $ChirpListing->readabilityScore = $Scores->getReadabilityScoreForPage($path, $ScoresForURLs);
        $ChirpListing->seoScore = $Scores->getSeoScoreForPage($path, $ScoresForURLs);
        $ChirpListing->keyword = $Keywords->getKeywordForURL($path, $KeywordsForURLs);

        $pages[] = $ChirpListing;
      }
    }

    include('global.list.pre.php');