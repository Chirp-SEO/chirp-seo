<?php
echo $HTML->title_panel([
  'heading' => PerchLang::get("Viewing Sitemap")
], $CurrentUser);
?>

<?php if ($error) echo $error; ?>
<?php if ($message) echo $message; ?>

<div class="smartbar">
  <ul>
    <li>
      <div class="breadcrumb tab-active">
        <a href="<?php echo PERCH_LOGINPATH . $API->app_nav() . '/'; ?>"><?php echo PerchLang::get('Sitemap'); ?></a>
      </div>
    </li>
    <li class="smartbar-end smartbar-util">
      <a href="<?php echo $sitemapURL; ?>" title="View Sitemap" class="viewext">
        <?php echo PerchUI::icon('core/o-world', 16, 'Page'); ?>
        <span>View Sitemap</span>
      </a>
    </li>
  </ul>
</div>

<?php

if (PerchUtil::count($pages)) {
  $Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

  $Listing->add_col([
    'title'     => 'URL',
    'value'     => function ($sitemapItem) {
      if (isset($sitemapItem["loc"])) {
        return $sitemapItem["loc"];
      }
    },
  ]);

  $Listing->add_col([
    'title'     => 'Frequency',
    'value'     => function ($sitemapItem) {
      if (isset($sitemapItem["changefreq"])) {
        return $sitemapItem["changefreq"];
      }
    },
  ]);

  $Listing->add_col([
    'title'     => 'Priority',
    'value'     => function ($sitemapItem) {
      if (isset($sitemapItem["priority"])) {
        return $sitemapItem["priority"];
      }
    },
  ]);

  $Listing->add_col([
    'title'     => 'HTTP Status',
    'value'     => function ($sitemapItem) {
      $ChirpSeo_Sitemap = new ChirpSeo_Sitemap($sitemapItem["loc"]);

      $status = $ChirpSeo_Sitemap->getStatus();
      $light = substr($status, 0, 1) === '2' ? 'green' : 'red';

      return '<span class="score ' . $light .  '"></span> ' . $status;
    },
  ]);

  echo $Listing->render($pages);
}
