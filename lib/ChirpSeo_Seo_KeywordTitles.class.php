<?php

class ChirpSeo_Seo_KeywordTitles extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_title_contents();
    $this->red_score = 0;
    $this->amber_score = 0;

    $this->calculate_score();
  }

  public function calculate_score() {
    $density_count = $this->analyse_text_keyword_titles($this->content);

    $this->score = round($density_count, 1);
  }

  public function get_description() {
    $description = "";

    if ($this->score <= $this->red_score) {
			$description = PerchLang::get("The keyword is found %s times in your headings, which can be improved. Try and include your keyword in the headings at least once.", $this->score);
		} else {
			$description = PerchLang::get("The keyword is found %s times in your headings, great job!", $this->score);
		}

    return $description;
  }

  private function analyse_text_keyword_titles($titles) {
    if (!$this->keyword || !$titles) {
      return 0;
    }

    $heading_count = 0;

    foreach($titles as $title) {
      $heading_count += substr_count(ChirpSeo_Util::format_string_for_check($title->text()), ChirpSeo_Util::format_string_for_check($this->keyword));
    }

    return $heading_count;
  }
}
