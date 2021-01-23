<?php

    $Blogs = new PerchBlog_Blogs($API);
    $Posts = new PerchBlog_Posts($API);

    // Find the page
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];

        $Post     = $Posts->find($id, true);
    }

    $details = $Post->to_array();

  	$Keywords = new ChirpSeo_Keywords($API);
		$Keyword    	 = false;
		$pageId  	 = false;
    $message   = false;
    $error = false;
    $locked = true;

    $url = $Post->postURL();

    if (PerchUtil::get('id')) {
			$postId = PerchUtil::get('id');
      $Keyword = $Keywords->findByURL(ChirpSeo_Util::get_page_path_from_url($url));
    }

    include('global.view.pre.php');