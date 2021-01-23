<?php

class ChirpSeo_Scores extends PerchAPI_Factory
{
    protected $table     = 'chirp_seo_scores';
	protected $pk        = 'scoreID';
	protected $singular_classname = 'ChirpSeo_Score';

	protected $default_sort_column = 'scoreID';

	public $static_fields   = array('scoreID', 'url', 'readabilityScore', 'seoScore', 'pagespeedScore');

  public function findByURL($url)
  {
      $sql = 'SELECT * FROM ' . $this->table . ' WHERE url="' . $url . '"';

      $row = $this->db->get_row($sql);

      $r = $this->return_instance($row);

      return $r;

      return false;
  }

  public function getScoresForPageUrls($Pages, $key, $Collection = false) {
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

    $Scores = $this->get_by('url', $pageUrls);

    return $Scores;
  }

  public function getReadabilityScoreForPage($path, $Scores) {
    $ReturnScore = false;

    if ($Scores) {
      foreach($Scores as $Score) {
        if ($Score->url() == $path) {
          $ReturnScore = $Score;
          break;
        }
      }

      if ($ReturnScore) {
        return $ReturnScore->readabilityScore();
      }
    }

    return false;
  }

  public function getSeoScoreForPage($path, $Scores) {
    $ReturnScore = false;

    if ($Scores) {
      foreach($Scores as $Score) {
        if ($Score->url() == $path) {
          $ReturnScore = $Score;
          break;
        }
      }

      if ($ReturnScore) {
        return $ReturnScore->seoScore();
      }
    }

    return false;
  }
}
