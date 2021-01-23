<?php

class ChirpSeo_Seo_PageTitle extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_page_title();

    $this->red_score = 0;
    $this->amber_score = 0.5;

    $this->calculate_score();
  }

  public function calculate_score() {
    parent::calculate_score();

    $this->score = 0;

    if ($this->keyword) {
      if (substr_count(ChirpSeo_Util::format_string_for_check($this->content), ChirpSeo_Util::format_string_for_check($this->keyword)) > 0) {
        $this->score = 1;
      }
    }
  }

  public function get_description() {
    $description = "";

    if ($this->score <= $this->red_score) {
			$description = PerchLang::get("The SEO title doesn't contain the focus keyword. A good format to use is 'Primary Keyword - Secondary Keyword | Brand Name'");
		} else {
			$description = PerchLang::get("The SEO title contains the focus keyword, good job!");
		}

    return $description;
  }
}
