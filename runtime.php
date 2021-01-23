<?php
    spl_autoload_register(function($class_name){
        if (strpos($class_name, 'ChirpSeo_')===0) {
            include(PERCH_PATH.'/addons/apps/chirp_seo/lib/'.$class_name.'.class.php');
            return true;
        }
        return false;
    });


    $API  = new PerchAPI(1.0, 'chirp_seo');
    $Settings = $API->get('Settings');
    $siteURL = $Settings->get('siteURL')->val();
    PerchSystem::set_var('siteURL', $siteURL);

    function chirp_seo_page_attributes($data = [], $opts = [], $return = false) {
      $API  = new PerchAPI(1.0, 'chirp_seo');

      $default_opts = array(
        'template'             => 'meta.html',
        'skip-template'        => false,
        'hide-extensions' => false
      );

      if (is_array($opts)) {
        $opts = array_merge($default_opts, $opts);
      } else {
        $opts = $default_opts;
      }

      $Settings = PerchSettings::fetch();
      $siteURL = rtrim($Settings->get('siteURL')->settingValue(), '/');
      $siteName = $Settings->get('perch_blog_site_name')->settingValue();
      $twittername = $Settings->get('chirp_seo_twitter_handler')->settingValue();
      $lang = $Settings->get('lang')->settingValue();
      $pageURL = perch_page_url([
        'include-domain' => false,
        'hide-extensions' => $opts['hide-extensions'],
      ], true);

      $default_data = array(
        'page_url' => $pageURL,
        'title' => perch_page_attribute('pageTitle', [], true),
        'description' => perch_page_attribute('description', [], true),
        'og_title' => perch_page_attribute('og_title', [], true),
        'og_description' => perch_page_attribute('og_description', [], true),
        'og_image' => perch_page_attribute('og_image', [], true),
        'twitter_name' => $twittername,
        'domain' => $siteURL,
        'site_name' => $siteName,
        'lang' => $lang,
        'og_type' => perch_page_attribute('og_type', [], true) ? perch_page_attribute('og_type', [], true) : 'website',
        'robots' => perch_page_attribute('noindex', [], true) . perch_page_attribute('nofollow', [], true) . perch_page_attribute('nosnippet', [], true),
        'schema' => perch_page_attribute('schema', [], true)
      );

      if (is_array($data)) {
        $data = array_merge($default_data, $data);
      } else {
        $data = $default_data;
      }

      $Template = $API->get('Template');
      $Template->set('chirp/'.$opts['template'], 'seo');

      $html = $Template->render($data);
      $html = $Template->apply_runtime_post_processing($html, $data);

      if ($return) return $html;
      echo $html;
    }

    function chirp_seo_blog_attributes($slug = false, $data = [], $opts = [], $return = false) {
      $API  = new PerchAPI(1.0, 'chirp_seo');

      $default_opts = array(
        'template'             => 'meta.html',
        'skip-template'        => false,
      );

      if (!$slug) {
        $slug = perch_get('s');
      }

      if (is_array($opts)) {
        $opts = array_merge($default_opts, $opts);
      } else {
        $opts = $default_opts;
      }

      $Settings = PerchSettings::fetch();
      $siteURL = rtrim($Settings->get('siteURL')->settingValue(), '/');
      $siteName = $Settings->get('perch_blog_site_name')->settingValue();
      $twittername = $Settings->get('chirp_seo_twitter_handler')->settingValue();
      $lang = $Settings->get('lang')->settingValue();
      $customlogo = $Settings->get('logoPath')->settingValue();
      $pageURL = perch_blog_post_field($slug, 'postURL', true);

      $default_data = array(
        'page_url' => $pageURL,
        'title' => perch_blog_post_field($slug, 'postTitle', true),
        'description' => perch_blog_post_field($slug, 'excerpt', true),
        'og_title' => perch_blog_post_field($slug, 'og_title', true),
        'og_description' => perch_blog_post_field($slug, 'og_description', true),
        'og_image' => perch_blog_post_field($slug, 'og_image', true),
        'twitter_name' => $twittername,
        'domain' => $siteURL,
        'site_name' => $siteName,
        'lang' => $lang,
        'og_type' => 'article',
        'author' => perch_blog_post_field($slug, 'authorGivenName', true) . ' ' . perch_blog_post_field($slug, 'authorFamilyName', true),
        'date_published' => perch_blog_post_field($slug, 'postDateTime', true),
        'date_modified' => perch_blog_post_field($slug, 'postDateTime', true),
        'publisher_logo' => $customlogo
      );

      if (is_array($data)) {
        $data = array_merge($default_data, $data);
      } else {
        $data = $default_data;
      }

      $Template = $API->get('Template');
      $Template->set('chirp/'.$opts['template'], 'seo');

      $html = $Template->render($data);
      $html = $Template->apply_runtime_post_processing($html, $data);

      if ($return) return $html;
      echo $html;
    }