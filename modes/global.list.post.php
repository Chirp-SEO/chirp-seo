<?php

  echo $HTML->title_panel([
    'heading' => $Lang->get('Summary'),
  ], $CurrentUser);

  if ($error) echo $error; 
  if ($message) echo $message;

  $path = $API->app_path('chirp_seo');

      if (PerchUtil::count($pages)) {

        $Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

        $Listing->add_col([
                'title'     => 'Title',
                'sort'      => 'title',
                'value'     => 'title',
                'edit_link' => isset($editLink) ? $editLink : 'view',
            ]);

        $Listing->add_col([
                'title'     => 'SEO Status',
                'value'     => function($ChirpListing) {
                  $Chirp_Seo = new ChirpSeo_ContentOverview($ChirpListing->path);
                  $light = $Chirp_Seo->get_traffic_light();
                  return '<span class="score ' . $light .  '"></span>';
                },
            ]);

        $Listing->add_col([
                'title'     => 'Readability Status',
                'value'     => function($ChirpListing) {
                  $Chirp_Seo = new ChirpSeo_ReadabilityOverview($ChirpListing->path);
                  $light = $Chirp_Seo->get_traffic_light();
                  return '<span class="score ' . $light .  '"></span>';
                },
            ]);

            $Listing->add_col([
                'title'     => 'Keyword',
                'value'     => function($Page) use ($path) {
                  $keyword = $Page->keyword;
                  return $keyword ?: '-';
                },
            ]);

        echo $Listing->render($pages);

      }

      $url = ChirpSeo_Util::get_set_website_url();

      if (empty($url)) {
        $error = '<div class="notification notification-warning">' . PerchLang::get("An error occurred. Please ensure you have set the correct website URL in %s Settings %s (e.g. http://yourdomain.co.uk)", '<a href="' . PERCH_LOGINPATH . '/core/settings">', '</a>') . '</div>';
      }

      if (!PerchUtil::count($pages)) {
        $message = '<div class="notification notification-info">' . PerchLang::get('No pages found.') . '</div>';
      }