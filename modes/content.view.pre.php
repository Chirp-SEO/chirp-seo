<?php

    $Pages   = new PerchContent_Pages;
    $Page  = false;

    // Find the page
    if (PerchUtil::get('id')) {
        $id = PerchUtil::get('id');

  			$Page = $Pages->find($id);
    }

    // Check we have a page
    if (!$Page || !is_object($Page)) {
        PerchUtil::redirect($API->app_path());
    }

    $url = $Page->pagePath();
    $details = $Page->to_array();

  	$Keywords = new ChirpSeo_Keywords($API);
		$Keyword    	 = false;
		$pageId  	 = false;
    $message   = false;
    $error = false;

    if (PerchUtil::get('id')) {
			$pageId = PerchUtil::get('id');
      $Keyword = $Keywords->findByURL(ChirpSeo_Util::get_page_path_from_url($url));
    }

    include('global.view.pre.php');