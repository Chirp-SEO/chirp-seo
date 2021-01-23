<?php

class ChirpSeo_Util
{
  static function filter_traffic_light_green($element) {
    return $element->get_traffic_light() == "green";
  }
  
  static function get_website_url() {
    $site_url = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];

    return $site_url;
  }
  
  static function get_set_website_url($page = false) {
    $API  = new PerchAPI(1.0, 'chirp_seo');
    $Settings = $API->get('Settings');
    $url = $Settings->get('siteURL')->val();

    if (empty($url)) {
      return false;
    }

    if ($url == "/") {
      $url = rtrim($url, "/");
    }

    if (substr($url, -1) == "/") {
      $url = rtrim($url, "/");
    }

    if ($page) {
      $url .= $page;
    }

    return $url;
  }

  static function get_page_path_from_collection($Collection, $itemID) {
    $url = false;

    if ($Collection) {
      $search_url = $Collection->get_option('searchURL');
      $details    = $Collection->get_items_for_editing($itemID);

      $Collection->tmp_url_vars = $details[0];
      $search_url = preg_replace_callback('/{([A-Za-z0-9_\-]+)}/', array($Collection, 'substitute_url_vars'), $search_url);
      $Collection->tmp_url_vars = false;

      if ($search_url) {
        $url = $search_url;
      }

      return $url;
    }

    return false;
  }

  static function get_page_path_from_url($url) {
    $API  = new PerchAPI(1.0, 'chirp_seo');
    $Settings = $API->get('Settings');
    $siteURL = $Settings->get('siteURL')->val();

    if (substr($siteURL, -1) != "/") {
      $path = str_replace($siteURL, '', $url);
    } else {
      $path = str_replace($siteURL, '/', $url);
    }

    return $path;
  }

  static function get_title_for_collection_item($Item) {
    if (is_array($Item)) {
      $details = $Item["itemJSON"];
    } else {
      $details = $Item->itemJSON();
    }
    
    $json = PerchUtil::json_safe_decode($details);

    if (isset($json->_title)) {
      $title = $json->_title;
    } else {
      $title = 'Item';
    }

    return $title;
  }

  static function get_product_url($Product) {
    $API  = new PerchAPI(1.0, 'chirp_seo');
    $Settings = $API->get('Settings');

    $product_dynamic = PerchUtil::json_safe_decode($Product->productDynamicFields(), true);
  
    $tmp_url_vars = false;
    if (PerchUtil::count($product_dynamic)) {
      foreach($product_dynamic as $key=>$val) {
          $tmp_url_vars[$key] = $val;
      }
    }

    $product_url     = $Settings->get('perch_shop_product_url')->settingValue();
    $product_url = preg_replace_callback('/{([A-Za-z0-9_\-]+)}/', function($matches) use ($tmp_url_vars) {
      $url_vars = $tmp_url_vars;
    	if (isset($url_vars[$matches[1]])){
    		return $url_vars[$matches[1]];
    	} 
    }, $product_url);

    return $product_url;
  }

  static function get_keyword_for_url($url) {
    $API  = new PerchAPI(1.0, 'chirp_seo');
    $Keywords = new ChirpSeo_Keywords($API);
    $keyword = '';
    $Keyword    	 = false;
    $Keyword = $Keywords->findByURL(ChirpSeo_Util::get_page_path_from_url($url));

    if (is_object($Keyword)) {
      $keyword = $Keyword->keywordTitle();
    }

    return $keyword;
  }

  static function format_string_for_check($string) {
    return strtolower(preg_replace("/[^0-9a-z\s-]/i", '', $string));
  }
}
