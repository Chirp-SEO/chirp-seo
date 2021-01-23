<?php

class ChirpSeo_Listing
{
  public $id;
  public $title = '';
  public $readabilityScore = 0;
  public $seoScore = 0;
  public $keyword = 0;
  public $path = 0;

  public function title() {
    return $this->title;
  }

  public function id() {
    return $this->id;
  }
}
