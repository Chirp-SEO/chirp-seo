<?php

    $Template   = $API->get('Template');
    $Template->set('chirp/keyword.html', 'seo');

    $Form = $API->get('Form');
    $tags = $Template->find_all_tags_and_repeaters();

    $Form->set_required_fields_from_template($Template, $details);

    if ($Form->submitted()) {
      $fixed_fields = $Form->receive(array('keywordTitle'));
      $data		 = $Form->get_posted_content($Template, $Keywords, $Keyword);

      $data = array_merge($data, $fixed_fields);
      $data["keywordURL"] = ChirpSeo_Util::get_page_path_from_url($url);

      if (is_object($Keyword)) {
          $Keyword->update($data);
      } else {
          $Keyword = $Keywords->create($data);
      }

      if (is_object($Keyword)) {
          $message = $HTML->success_message('Keyword updated.');
      } else {
          $message = $HTML->failure_message('Sorry, error occured.');
      }

    }

    if (is_object($Keyword)) {
      $keyword = $Keyword->keywordTitle();
    } else {
      $keyword = false;
      $error = '<div class="notification notification-warning">' . PerchLang::get("To analyse your page, please set a keyword.") . '</div>';
    }

    $snippet_url = false;
    $snippet_title = false;
    $snippet_meta_description = false;
    $formattedUrl = false;

    $formattedUrl = ChirpSeo_Util::get_set_website_url($url);
    $ChirpSeo_Parser = new ChirpSeo_Parser($formattedUrl);

    $error = $ChirpSeo_Parser->errorMessage;

    if (!$error) {
      $ChirpSeo_Content = new ChirpSeo_ContentOverview($formattedUrl, false, $ChirpSeo_Parser, false);
      $ChirpSeo_Readability = new ChirpSeo_ReadabilityOverview($formattedUrl, false, $ChirpSeo_Parser, false);
      $Seo_PageInsights = new ChirpSeo_PageInsights($formattedUrl);

      $snippet_url = $formattedUrl;
      $snippet_title = $ChirpSeo_Parser->get_title_snippet();
      $snippet_meta_description = $ChirpSeo_Parser->get_meta_description_snippet();

      $og_url = $ChirpSeo_Parser->get_og_url() ?: $formattedUrl;
      $og_title = $ChirpSeo_Parser->get_og_title() ?: $snippet_title;
      $og_description = $ChirpSeo_Parser->get_og_description() ?: $snippet_meta_description;
      $og_image = $ChirpSeo_Parser->get_og_image();
    } else {
      $error = '<div class="notification notification-alert">' . PerchLang::get("%s. It could be that you haven't set a correct website URL in %sSettings%s (maybe, possibly)", $error, '<a href="' . PERCH_LOGINPATH . '/core/settings">', '</a>') . '</div>';
    }