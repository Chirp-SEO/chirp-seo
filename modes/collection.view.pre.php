<?php

  $Collections = new PerchContent_Collections();
  $Items = new PerchContent_CollectionItems();

  $Keywords = new ChirpSeo_Keywords($API);
  $Keyword    	 = false;
  $pageId  	 = false;
  $message   = false;
  $error = false;
  $details = false;
  $locked = true;

  // Find the page
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $collectionID = (int) $_GET['collection'];
    $itemID = (int) $_GET['id'];

    $Collection = $Collections->find($collectionID);
    $Item = $Items->find_item($collectionID, $itemID);
    $details    = $Collection->get_items_for_editing($itemID);
  }

  $url = ChirpSeo_Util::get_page_path_from_collection($Collection, $itemID);

  if ($url == "") {
    $error = "An error occurred. Please ensure you've set the 'URL for single items'.";
  }

  if (PerchUtil::get('id')) {
    $collectionId = PerchUtil::get('id');
    $Keyword = $Keywords->findByURL(ChirpSeo_Util::get_page_path_from_url($url));
  }

  $details  = $Item->to_array();
  
  include('global.view.pre.php');