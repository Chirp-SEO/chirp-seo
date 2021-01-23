<?php

class ChirpSeo_Seo_ImageAltTags extends ChirpSeo_Base
{

  function __construct($url, $keyword = false, $ChirpParser)
  {
    parent::__construct($url, $keyword, $ChirpParser);

    $this->content = $this->ChirpParser->get_image_tags();
    $this->red_score = 3;
    $this->amber_score = 1;
    $this->green_score = 0;
    $this->score = 0;

    $this->calculate_score();
  }

  public function calculate_score() {
    if ($this->content) {
      $total_images = count($this->content);
      $alt_count = 0;

      foreach($this->content as $instance) {
        if ($instance->alt) {
          $alt_count++;
        }
      }

      $this->score = $total_images - $alt_count; 
    }
  }

  private function calculate_score_percentage() {
    $total_images = count($this->content);
    $alt_count = 0;

    foreach($this->content as $instance) {
      if ($instance->alt) {
        $alt_count++;
      }
    }

    return $alt_count / $total_images * 100;
  }

  public function get_traffic_light() {
    if ($this->score == $this->red_score) {
      return "red";
    } else if ($this->score <= $this->amber_score && $this->score > $this->green_score) {
      return "amber";
    }

    return "green";
  }

  public function get_description() {
    $description = "";
    if ($this->score == $this->red_score) {
			$description = PerchLang::get("%s image(s) are missing alternative text. Work on this!", $this->score);
    } else if ($this->score <= $this->amber_score && $this->score > $this->green_score) {
			$description = PerchLang::get("%s image(s) are missing alternative text. Keep going!", $this->score);
    } else {
      $description = PerchLang::get("All image(s) have alternative text, now that's the way to go!");
		}

    return $description;
  }
}
