<?php
  $Pages      = new PerchContent_Pages;

  $Paging->set_per_page(15);
  $Template   = $API->get('Template');
  $Template->set('chirp/sitemap.html', 'seo');
  
  $Form = $API->get('Form');

  $Settings = PerchSettings::fetch();
  $sitemap = $Settings->get('chirp_seo_sitemap_url')->settingValue();
  $sitemapURL = ChirpSeo_Util::get_set_website_url($sitemap);
  $ChirpSeo_Sitemap = new ChirpSeo_Sitemap($sitemap);

  $error = false;
  $message = false;

  $pages = $ChirpSeo_Sitemap->getSitemapItems($Paging);

  if (!$pages) {
    $error = '<div class="notification notification-alert">' . PerchLang::get("Could not parse sitemap, please make sure the sitemap is accessible and valid." . '</div>');
  }

  if (!$sitemap) {
    $error = '<div class="notification notification-alert">' . PerchLang::get("Please set a correct sitemap URL in %sSettings%s", '<a href="' . PERCH_LOGINPATH . '/core/settings">', '</a>') . '</div>';
  }

  if ($ChirpSeo_Sitemap->errorMessage) {
    $error = '<div class="notification notification-warning">' . PerchLang::get("%s", $ChirpSeo_Sitemap->errorMessage) . '</div>';
  }