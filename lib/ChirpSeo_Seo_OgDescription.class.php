<?php

class ChirpSeo_Seo_OgDescription extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_og_description();

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
			$description = PerchLang::get("The site doesn't contain an og:description tag. Writing some descriptive text can increase sharability and increase exposure.");
		} else {
			$description = PerchLang::get("The og:description tag is present, wow you're good!");
		}

    return $description;
  }
}
