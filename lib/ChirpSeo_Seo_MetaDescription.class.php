<?php

class ChirpSeo_Seo_MetaDescription extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_meta_description();
    $this->red_score = 0;
    $this->amber_score = 140;
    $this->green_score = 160;

    $this->calculate_score();
  }

  public function calculate_score() {
    $this->score = strlen($this->content);
  }

  public function get_traffic_light() {
    if ($this->score == $this->red_score) {
      return "red";
    } else if ($this->score >= $this->amber_score && $this->score <= $this->green_score) {
      return "green";
    }

    return "amber";
  }

  public function get_description() {
    $description = "";

    if ($this->score == $this->red_score) {
			$description = PerchLang::get("You haven't set a meta description. Well written descriptions help click-through rate.");
    } else if ($this->score >= $this->amber_score && $this->score <= $this->green_score) {
			$description = PerchLang::get("The meta description is under %s characters and over %s! Awesome job.", $this->green_score, $this->amber_score);
    } else {
      $description = PerchLang::get("The meta description is %s characters! Ideal meta description length is under %s and over %s. Well written descriptions help click-through rate.", $this->score, $this->green_score, $this->amber_score);
		}

    return $description;
  }
}
