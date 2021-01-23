<?php

class ChirpSeo_Seo_Canonical extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->red_score = 0;
    $this->amber_score = 0.5;
    $this->content = $this->ChirpParser->get_canonical();

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
			$description = PerchLang::get('The page does not contain an canonical tag. Canonicals help tell Google that some URLs are the same and stops duplicate URL submissions. <a href="%s" target="_blank" rel="noopener noreferrer">Read more...</a>', "https://moz.com/blog/rel-canonical");
		} else {
			$description = PerchLang::get("The canonical tag is present, you genius you!");
		}

    return $description;
  }
}
