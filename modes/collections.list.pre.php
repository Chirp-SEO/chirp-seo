<?php    
    $HTML = $API->get('HTML');

    $Keywords = new ChirpSeo_Keywords($API);

    $keywords = array();
    $error = false;
    $message = false;
    $locked = true;

    $keywords = $Keywords->all();

    // Install only if $things is false.
    // This will run the code in activate.php so should only ever happen on first run - silently installing the app.
    if ($keywords == false) {
    	$Keywords->attempt_install();
    }

    $collectionID = (int)PerchUtil::get('id');

    $collections = false;

    if (PERCH_RUNWAY) {
      $Collections = new PerchContent_Collections();

      $all_collections = $Collections->get_by('collectionSearchable', '1', 'collectionID');
      $collections = [];

      if ($all_collections) {
        foreach($all_collections as $Collection) {
          $details = $Collection->collectionOptions();
          $json = PerchUtil::json_safe_decode($details);

          if (isset($json->searchURL) && !empty($json->searchURL)) {
            $collections[] = $Collection;
          }
        }
      } 

      $url = ChirpSeo_Util::get_set_website_url();
      
      if (empty($url)) {
        $error = '<div class="notification notification-warning">' . PerchLang::get("An error occurred. Please ensure you have set the correct website URL in %s Settings %s (e.g. http://yourdomain.co.uk)", '<a href="' . PERCH_LOGINPATH . '/core/settings">', '</a>') . '</div>';
      }

      if (!PerchUtil::count($collections)) {
        $message = '<div class="notification notification-info">' . PerchLang::get('No suitable collections found.') . '</div>';
      }
    }