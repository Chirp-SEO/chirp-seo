<?php

use DaveChild\TextStatistics;

class ChirpSeo_Readability_FleschKincaid extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_paragraph_contents();

    $this->red_score = 50;
    $this->amber_score = 60;

    $this->calculate_score();
  }

  public function calculate_score() {
    $this->score = $this->analyse_text_flesch_kincaid($this->content);
  }

  public function get_description() {
    $description = "";

    if ($this->score <= $this->red_score) {
			$description = PerchLang::get("The copy scores %s in the Flesch Reading Ease test, which is considered a little bit difficult to read. Try to make sentences shorter and make sure sentences flow.", $this->score);
    } else if ($this->score <= $this->amber_score) {
			$description = PerchLang::get("The copy scores %s in the Flesch Reading Ease test, which is considered okay to read. Try to make sentences shorter and make sure sentences flow.", $this->score);
		} else {
			$description = PerchLang::get("The copy scores %s in the Flesch Reading Ease test, which is considered good to read. Way to go!", $this->score);
		}

    return $description;
  }

  private function analyse_text_flesch_kincaid($paragraphs) {
    if (!$this->content) {
      return false;
    }

    $textStatistics = new DaveChild\TextStatistics\TextStatistics;
    $scores = array();

    foreach ($paragraphs as $paragraph) {
      $scores[] = round($textStatistics->fleschKincaidReadingEase($paragraph->text()), 1);
    }

    $score_total = 0;

    foreach($scores as $score) {
      $score_total += $score;
    }

    if (count($paragraphs)) {
      $score_average = $score_total / count($paragraphs);
      return round($score_average, 1);
    } else {
      return 0;
    }
  }

}
