<?php

class ChirpSeo_ContentOverview
{
  protected $url = false;
  protected $ChirpScore = 0;
  protected $score = 0;
  protected $red_score = 33;
  protected $amber_score = 66;
  protected $keyword = false;
  protected $tests = [];

  function __construct($url, $keyword = false, $ChirpSeo_Parser = false, $from_cache = true, $store_results = true)
  {
    $this->url = $url;
    $this->keyword = $keyword ?: ChirpSeo_Util::get_keyword_for_url($this->url);

    if ($ChirpSeo_Parser) {
      $this->ChirpSeo_Parser = $ChirpSeo_Parser;
    }

    if ($from_cache) {
      $this->score = $this->get_score_from_database();
    } else {
      $this->score = $this->calculate_score();

      if ($store_results) {
        $this->updateScore();
      }
    }
  }

  public function get_tests() {
    return $this->tests;
  }

  public function get_traffic_light() {
    $score = $this->score;

    if (!$this->keyword) {
      return "warning";
    }

    if ($score <= $this->red_score) {
      return "red";
    } else if ($score <= $this->amber_score) {
      return "amber";
    }

    return "green";
  }

  public function get_title() {
    if ($this->score <= $this->red_score) {
      $title = "Get to work!";
    } else if ($this->score <= $this->amber_score) {
      $title = "Good job!";
    } else {
      $title = "Nailed it!";
    }

    return $title;
  }

  public function get_description() {
    if ($this->score <= $this->red_score) {
      $description = PerchLang::get("Your Search Engine Optimisation could be improved. Check the suggestions below.");
    } else if ($this->score <= $this->amber_score) {
      $description = PerchLang::get("Your Search Engine Optimisation is good, you're doing mighty fine!");
    } else {
      $description = PerchLang::get("Your Search Engine Optimisation is on point. &#128076;");
    }

    return $description;
  }

  private function get_score_from_database() {
    $ChirpScores = new ChirpSeo_Scores();
    $ChirpScore = $ChirpScores->findByURL(ChirpSeo_Util::get_page_path_from_url($this->url));
    
    if ($ChirpScore) {
      $score = (int) $ChirpScore->seoScore();
    } else {
      $score = $this->calculate_score();
    }

    return $score;
  }

  private function calculate_score() {
    $url = $this->url;

    if (!isset($this->ChirpSeo_Parser)) {
      $this->ChirpSeo_Parser = new ChirpSeo_Parser($url);
    }

    $Seo_KeywordDensity = new ChirpSeo_Seo_KeywordDensity($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_KeywordTitles = new ChirpSeo_Seo_KeywordTitles($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_PageTitle = new ChirpSeo_Seo_PageTitle($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_PageTitleLength = new ChirpSeo_Seo_PageTitleLength($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_MetaDescription = new ChirpSeo_Seo_MetaDescription($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_ImageAltTags = new ChirpSeo_Seo_ImageAltTags($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_OgTitle = new ChirpSeo_Seo_OgTitle($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_OgDescription = new ChirpSeo_Seo_OgDescription($url, $this->keyword, $this->ChirpSeo_Parser);
    $Seo_Canonical = new ChirpSeo_Seo_Canonical($url, $this->keyword, $this->ChirpSeo_Parser);

    $this->tests = [$Seo_PageTitle, $Seo_MetaDescription, $Seo_KeywordDensity, $Seo_KeywordTitles, $Seo_PageTitleLength, $Seo_ImageAltTags, $Seo_OgTitle, $Seo_OgDescription, $Seo_Canonical];

    $tests_green = array_filter($this->tests, array(new ChirpSeo_Util, 'filter_traffic_light_green'));
    $score = (int) round(count($tests_green) / count($this->tests) * 100, 1);

    return $score;
  }

  private function updateScore() {
    $ChirpScores = new ChirpSeo_Scores();
    $ChirpScore = $ChirpScores->findByURL(ChirpSeo_Util::get_page_path_from_url($this->url));

    if ($ChirpScore) {
      $ChirpScore->update([
        'seoScore' => $this->score
      ]);
    } else {
      $ChirpScores = new ChirpSeo_Scores();

      $ChirpScores->create([
        'url' => ChirpSeo_Util::get_page_path_from_url($this->url),
        'seoScore' => $this->score
      ]);
    }
  }
}
