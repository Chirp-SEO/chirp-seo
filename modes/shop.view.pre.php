<?php

    $Products = new PerchShop_Products($API);

    // Find the page
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];

        $Product     = $Products->find($id, true);
    }

    $details = $Product->to_array();

  	$Keywords = new ChirpSeo_Keywords($API);
		$Keyword    	 = false;
		$pageId  	 = false;
    $message   = false;
    $error = false;

    $product = $Product->to_array();

    $tmp_url_vars['title']    = $product['title'];
    $tmp_url_vars['slug']     = $product['productSlug'];
    $tmp_url_vars['_id']      = $product['productID'];

    $url = ChirpSeo_Util::get_product_url($Product);

    if (PerchUtil::get('id')) {
			$productId = PerchUtil::get('id');
      $Keyword = $Keywords->findByURL(ChirpSeo_Util::get_page_path_from_url($url));
    }

    $details  = $Product->to_array();
    
    include('global.view.pre.php');