<?php

class ChirpSeo_PageInsights extends ChirpSeo_Base
{
  private $url = false;

  function __construct($url)
  {
    $this->url = $url;
  }

  public function get_traffic_light()
  {
    return "amber";
  }

  public function get_title()
  {
    return "Performance is key!";
  }

  public function get_description()
  {
    $description = "";

    $description = PerchLang::get("Be sure to check your Google PageSpeed insights score. You can view feedback %shere%s.", '<a href="https://developers.google.com/speed/pagespeed/insights/?url=' . $this->url . '&tab=desktop" target="_blank">', '</a>');

    return $description;
  }
}
