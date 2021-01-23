<?php

class PerchFieldType_chirpseo extends PerchFieldType
{
    public function render_inputs($details=array())
    {
      $this->render($details);
    }

    public function add_page_resources()
    {
      $Perch = Perch::fetch();
      $Perch->add_css(PERCH_LOGINPATH.'/addons/apps/chirp_seo/assets/css/seo.css');
      $Perch->add_javascript(PERCH_LOGINPATH.'/addons/apps/chirp_seo/assets/js/app.js');
    }

    private function render($details) {
      $API  = new PerchAPI(1.0, 'chirp_seo');
      $HTML   = $API->get('HTML');
      $Lang   = $API->get('Lang');
      $Paging = $API->get('Paging');

      $Pages   = new PerchContent_Pages;
      $Page  = false;
      
      $Keywords = new ChirpSeo_Keywords($API);
      $Keyword    	 = false;
      
      $error = false;
      $message = false;

      $Page = $Pages->find($details["pageID"]);

      $url = $Page->pagePath();
      $keyword = ChirpSeo_Util::get_keyword_for_url($url);

      if (!$keyword) {
        $error = '<div class="notification notification-warning">' . PerchLang::get("To analyse your page, please set a keyword.") . '</div>';
      }
      
      $snippet_url = false;
      $snippet_title = false;
      $snippet_meta_description = false;
      $formattedUrl = false;

      try {
        $formattedUrl = ChirpSeo_Util::get_set_website_url($url);
        $ChirpSeo_Parser = new ChirpSeo_Parser($formattedUrl);
        $Seo_PageInsights = new ChirpSeo_PageInsights($formattedUrl);
        $ChirpSeo_Content = new ChirpSeo_ContentOverview($formattedUrl, false, $ChirpSeo_Parser, false);
        $ChirpSeo_Readability = new ChirpSeo_ReadabilityOverview($formattedUrl, false, $ChirpSeo_Parser, false);
  
        $snippet_url = $formattedUrl;
        $snippet_title = $ChirpSeo_Parser->get_title_snippet();
        $snippet_meta_description = $ChirpSeo_Parser->get_meta_description_snippet();
  
        $og_url = $ChirpSeo_Parser->get_og_url() ?: $formattedUrl;
        $og_title = $ChirpSeo_Parser->get_og_title() ?: $snippet_title;
        $og_description = $ChirpSeo_Parser->get_og_description() ?: $snippet_meta_description;
        $og_image = $ChirpSeo_Parser->get_og_image();
      } catch (Exception $e) {
        $error = '<div class="notification notification-warning">' . PerchLang::get("An error occurred. Please ensure you have set the correct website URL in %s Settings %s", '<a href="' . PERCH_LOGINPATH . '/core/settings">', '</a>') . '</div>';
      }

      if ($error) echo $error;
      if ($message) echo $message;

      include_once('modes/global.view.post.php');
    }
}