<?php

class ChirpSeo_Keywords extends PerchAPI_Factory
{
    protected $table     = 'chirp_seo';
	protected $pk        = 'keywordID';
	protected $singular_classname = 'ChirpSeo_Keyword';

	protected $default_sort_column = 'keywordID';

	public $static_fields   = array('keywordID', 'keywordTitle', 'keywordURL', 'keywordDynamicFields');

  public function findByURL($url)
  {
      $sql = 'SELECT * FROM ' . $this->table . ' WHERE keywordURL="' . $url . '"';

      $row = $this->db->get_row($sql);

      $r = $this->return_instance($row);

      return $r;

      return false;
  }

  public function getKeywordsForPageUrls($Pages, $key, $Collection = false) {
    $pageUrls = array();
    foreach($Pages as $Page) {
      if ($key == 'shop') {
        $url = ChirpSeo_Util::get_product_url($Page);
        $pageUrls[] = $url;
      } else if ($key == 'collection') {
        $url = ChirpSeo_Util::get_page_path_from_collection($Collection, $Page["itemID"]);
        $pageUrls[] = $url;
      } else {
        $pageUrls[] = $Page->{$key}();
      }
    }

    $Keywords = $this->get_by('keywordURL', $pageUrls);

    return $Keywords;
  }

  public function getKeywordForURL($path, $Keywords) {
    $ReturnKeyword = false;

    if ($Keywords) {
      foreach($Keywords as $Keyword) {
        if ($Keyword->keywordURL() == $path) {
          $ReturnKeyword = $Keyword;
          break;
        }
      }

      if ($ReturnKeyword) {
        return $ReturnKeyword->keywordTitle();
      }
    }

    return false;
  }
}
