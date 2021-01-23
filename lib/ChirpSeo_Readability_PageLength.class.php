<?php

class ChirpSeo_Readability_PageLength extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_all_contents();
    $this->red_score = 300;

    $this->calculate_score();
  }

  public function calculate_score() {
    if ($this->content) {
      $instances = $this->content;
      $words = "";

      foreach($instances as $instance) {
        $words .= " " . $instance->text();
      }

      $word_count = str_word_count($words);

      $this->score = $word_count;
    }
  }

  public function get_traffic_light() {
    if ($this->score < $this->red_score) {
      return "red";
    }

    return "green";
  }

  public function get_description() {
    $description = "";

    if ($this->score >= $this->red_score) {
			$description = PerchLang::get("The total page word count is %s, over %s words! Awesome job.", $this->score, $this->red_score);
		} else {
			$description = PerchLang::get("The total page word count is %s, under %s words! Try and include at least %s words.", $this->score, $this->red_score, $this->red_score);
		}

    return $description;
  }
}
