<?php

class ChirpSeo_Seo_OgTitle extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_og_title();
    $this->red_score = 0;
    $this->amber_score = 0.5;

    $this->calculate_score();
  }

  public function calculate_score() {
    parent::calculate_score();

    $this->score = 0;

    if (!empty($this->content)) {
      $this->score = 1;
    }
  }

  public function get_description() {
    $description = "";

    if ($this->score <= $this->red_score) {
			$description = PerchLang::get("The site doesn't contain an og:title tag. Writing a well optimised tag can increase sharability and increase exposure.");
		} else {
			$description = PerchLang::get("The og:title tag is present, BOOM! (as the kids say)!");
		}

    return $description;
  }
}
