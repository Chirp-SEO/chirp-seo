<?php

class ChirpSeo_Base
{
  protected $keyword = 0;
  protected $red_score = 1;
  protected $amber_score = 1;
  protected $green_score = 1;
  protected $score = 0;

  function __construct($url, $keyword = false, $ChirpParser)
  {
    $this->ChirpParser = $ChirpParser;
    $this->keyword = $keyword;
  }

  public function get_traffic_light() {
    if ($this->score <= $this->red_score) {
      return "red";
    } else if ($this->score <= $this->amber_score) {
      return "amber";
    }

    return "green";
  }

  public function get_description() {
    return "";
  }

  public function calculate_score() {
    if (!$this->keyword) {
      $this->score = 0;
      return;
    }
  }

  public function get_score() {
    return $this->score;
  }
}
