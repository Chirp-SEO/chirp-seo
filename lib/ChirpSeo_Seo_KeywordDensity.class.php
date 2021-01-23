<?php

class ChirpSeo_Seo_KeywordDensity extends ChirpSeo_Base
{

  private $lower_limit = 0.5;
  private $upper_limit = 2;

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_all_contents();

    $this->calculate_score();
  }

  public function calculate_score() {
    $density_count = $this->analyse_text_keyword_density($this->content);

    $this->score = round($density_count, 1);
  }

  public function get_traffic_light() {
    if ($this->calculate_score_percentage() >= $this->lower_limit && $this->calculate_score_percentage() <= $this->upper_limit) {
      return "green";
    }

    return "red";
  }

  public function get_description() {
    $description = "";

    if ($this->calculate_score_percentage() >= $this->lower_limit && $this->calculate_score_percentage() <= $this->upper_limit) {
			$description = PerchLang::get("The keyword density is %s%%, found %s times in your copy. Well done!", $this->calculate_score_percentage(), $this->score, $this->lower_limit, $this->upper_limit);
		} else {
			$description = PerchLang::get("The keyword density is %s%%, found %s times in your copy. Ideal keyword density is between %s%% and %s%%.", $this->calculate_score_percentage(), $this->score, $this->lower_limit, $this->upper_limit);
		}

    return $description;
  }

  private function calculate_score_percentage() {
    $all_content = "";

    if ($this->content) {
      foreach($this->content as $instance) {
        $all_content .= " " . $instance->text();
      }

      $word_count = str_word_count($all_content);

      if ($word_count) {
        return round(($this->score / $word_count) * 100, 1);
      } else {
        return 0;
      }
    } else {
      return 0;
    }
  }

  private function analyse_text_keyword_density($contents) {
    if (!$this->keyword) {
      return 0;
    }

    $density = 0;
    $formattedKeyword = ChirpSeo_Util::format_string_for_check($this->keyword);

    if ($contents) {
      foreach($contents as $instance) {
        $formattedInstance = ChirpSeo_Util::format_string_for_check($instance->text());
        $density += substr_count($formattedInstance, $formattedKeyword);
      }
    }

    return $density;
  }
}
