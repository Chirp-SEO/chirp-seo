<?php

class ChirpSeo_ReadabilityOverview
{
  protected $score = 0;
  protected $ChirpScore = 0;
  protected $red_score = 33;
  protected $amber_score = 66;
  protected $cache = false;
  protected $tests = [];
  protected $keyword = false;

  function __construct($url, $keyword = false, $ChirpSeo_Parser = false, $from_cache = true, $store_results = true)
  {
    $this->url = $url ?: ChirpSeo_Util::get_set_website_url($url);
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

    if (!$this->keyword || !$score) {
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
      $description = PerchLang::get("Your readability could be improved. Check the suggestions.");
    } else if ($this->score <= $this->amber_score) {
      $description = PerchLang::get("Your readability is good, you're on the right track!");
    } else {
      $description = PerchLang::get("Your readability is really good, gold star for you!");
    }

    return $description;
  }

  private function get_score_from_database() {
    $ChirpScores = new ChirpSeo_Scores();
    $ChirpScore = $ChirpScores->findByURL(ChirpSeo_Util::get_page_path_from_url($this->url));
    
    if ($ChirpScore) {
      $score = (int) $ChirpScore->readabilityScore();
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

    $Readability_FleschKincaid = new ChirpSeo_Readability_FleschKincaid($url, $this->keyword, $this->ChirpSeo_Parser);
    $Readability_Paragraph = new ChirpSeo_Readability_Paragraph($url, $this->keyword, $this->ChirpSeo_Parser);
    $Readability_Sentence = new ChirpSeo_Readability_Sentence($url, $this->keyword, $this->ChirpSeo_Parser);
    $Readability_PageLength = new ChirpSeo_Readability_PageLength($url, $this->keyword, $this->ChirpSeo_Parser);

    $this->tests = [$Readability_FleschKincaid, $Readability_Paragraph, $Readability_Sentence, $Readability_PageLength];

    $tests_green = array_filter($this->tests, array(new ChirpSeo_Util, 'filter_traffic_light_green'));
    $score = round(count($tests_green) / count($this->tests) * 100, 1);

    return $score;
  }

  private function updateScore() {
    $ChirpScores = new ChirpSeo_Scores();
    $ChirpScore = $ChirpScores->findByURL(ChirpSeo_Util::get_page_path_from_url($this->url));

    if ($ChirpScore) {
      $ChirpScore->update([
        'readabilityScore' => $this->score
      ]);
    } else {
      $ChirpScores = new ChirpSeo_Scores();

      $ChirpScores->create([
        'url' => ChirpSeo_Util::get_page_path_from_url($this->url),
        'readabilityScore' => $this->score
      ]);
    }
  }
}
