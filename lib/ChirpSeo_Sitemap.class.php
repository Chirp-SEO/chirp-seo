<?php

use DiDom\Document;
use DiDom\Query;

class ChirpSeo_Sitemap
{
  protected $url = false;

  function __construct($url)
  {
    $this->url = $url;
    $this->errorMessage = false;
  }

  public function getSitemapItems($Paging) {
    $formattedURL = ChirpSeo_Util::get_set_website_url($this->url);
    $return = [];

    if (!empty($this->url)) {
      try {
        $document = new Document($formattedURL, true, 'UTF-8', Document::TYPE_XML);
        $items = $document->find('//*[local-name()="url"]', Query::TYPE_XPATH);

        $return = [];
    
        if ($items) {
          foreach($items as $item) {
            $itemReturn = [];
    
            $loc = $item->find('//*[local-name()="loc"]', Query::TYPE_XPATH);
            $changefreq = $item->find('//*[local-name()="changefreq"]', Query::TYPE_XPATH);
            $priority = $item->find('//*[local-name()="priority"]', Query::TYPE_XPATH);
    
            if (count($loc)) {
              $itemReturn['loc'] = $loc[0]->text();
            }
    
            if (count($changefreq)) {
              $itemReturn['changefreq'] = $changefreq[0]->text();
            }
    
            if (count($priority)) {
              $itemReturn['priority'] = $priority[0]->text();
            }
    
            $return[] = $itemReturn;
          }
        } else {
          return false;
        }
      } catch (Exception $e) {
        $this->errorMessage = $e->getMessage();
      }

      $Paging->set_total(count($return));

      return array_splice($return, $Paging->lower_bound(), $Paging->per_page());
    }

    return false;
  }

  public function getStatus() {
    $handle = curl_init($this->url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);

    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    return $httpCode;
  }
}
