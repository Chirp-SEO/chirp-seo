<?php

use DaveChild\TextStatistics;

class ChirpSeo_Readability_Sentence extends ChirpSeo_Base
{

  private $ideal_sentence_length = 25;

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_paragraph_contents();

    $this->red_score = 50;
    $this->amber_score = 20;

    $this->calculate_score();
  }

  public function calculate_score() {
    if (!$this->content) {
      return false;
    }

    $bad_sentences_scores = 0;

    foreach($this->content as $instance) {
      $sentences = explode('.', $instance->text());
      $sentences = array_filter($sentences);

      foreach($sentences as $sentence) {
        if (!$this->analyse_text_sentence_length($sentence)) {
          $bad_sentences_scores++;
        }
      }
    }

    $this->score = $bad_sentences_scores;
  }

  public function get_description() {
    $description = "";

     if ($this->calculate_score_percentage() > $this->amber_score) {
			$description = PerchLang::get("%s%% of the sentences contain more than %s words, which is more than or equal to the recommended maximum of %s%%.", $this->calculate_score_percentage(), $this->ideal_sentence_length, $this->amber_score);
		} else {
			$description = PerchLang::get("%s%% of the sentences contain more than %s words, which is less than to the recommended maximum of %s%%.", $this->calculate_score_percentage(), $this->ideal_sentence_length, $this->amber_score);
		}

    return $description;
  }

  public function get_traffic_light() {

    if ($this->calculate_score_percentage() > $this->red_score) {
      return "red";
    } else if ($this->calculate_score_percentage() > $this->amber_score) {
      return "amber";
    }

    return "green";
  }

  private function calculate_score_percentage() {
    if (!$this->content) {
      return false;
    }
  
    $bad_sentences_scores = 0;
    $total_sentences = 0;

    foreach($this->content as $instance) {
      $sentences = explode('.', $instance);
      $sentences = array_filter($sentences);

      $total_sentences += count($sentences);
    }

    if ($this->score != 0) {
      $percentage_long_sentences = ($this->score / $total_sentences) * 100;
    } else {
      $percentage_long_sentences = 0;
    }

    return round($percentage_long_sentences, 1);
  }

  private function analyse_text_sentence_length($text) {
    if (str_word_count($text) < $this->ideal_sentence_length) {
      return true;
    } else {
      return false;
    }
  }

}
