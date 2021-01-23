<?php if ($keyword && !$error) { ?>

<div class="form-simple">
  <div class="inner">

    <div class="field-wrap">
      <div class="dashboard">
        <div data-app="seo" class="widget">
          <div class="dash-content">
            <header>
              <h2>SEO</h2>
            </header>
          </div>
          <div class="panel clearfix">
            <div class="pulse" data-status="<?php echo $ChirpSeo_Content->get_traffic_light(); ?>">
              <div class="status">
              </div>
            </div>
            <h2><?php echo $ChirpSeo_Content->get_title(); ?></h2>
            <p><?php echo $ChirpSeo_Content->get_description(); ?></p>
          </div>
        </div>
        <div data-app="readability" class="widget">
          <div class="dash-content">
            <header>
              <h2>Readability</h2>
            </header>
          </div>
          <div class="panel clearfix">
            <div class="pulse" data-status="<?php echo $ChirpSeo_Readability->get_traffic_light(); ?>">
              <div class="status">
              </div>
            </div>
            <h2><?php echo $ChirpSeo_Readability->get_title(); ?></h2>
            <p><?php echo $ChirpSeo_Readability->get_description(); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h2 class="divider"><div>SEO Analysis</div></h2>

  <div class="field-wrap">
    <div class="inner">
      <div>
        <table class="d">
            <thead>
                <tr>
                    <th class="first"></th>
                    <th class="first"><?php echo PerchLang::get('Title'); ?></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($ChirpSeo_Content->get_tests() as $seo_row) { ?>
                <tr>
                    <td><span class="score <?php echo $seo_row->get_traffic_light(); ?>"></span></td>
                    <td><?php echo $seo_row->get_description(); ?></td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>

  <h2 class="divider"><div>Readability Analysis</div></h2>

  <div class="field-wrap">
    <div class="inner">
      <div>
        <table class="d">
            <thead>
                <tr>
                    <th class="first"></th>
                    <th class="first"><?php echo PerchLang::get('Title'); ?></th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($ChirpSeo_Readability->get_tests() as $readability_row) { ?>
                <tr>
                    <td><span class="score <?php echo $readability_row->get_traffic_light(); ?>"></span></td>
                    <td><?php echo $readability_row->get_description(); ?></td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>

  <h2 class="divider"><div>Google Preview</div></h2>

  <div class="field-wrap">
    <div class="inner">
      <div>
        <div class="snippet">
          <h3 class="title"><?php echo $snippet_title; ?></h3>
          <p class="url"><?php echo $snippet_url; ?></p>
          <p class="description"><?php echo $snippet_meta_description; ?></p>
        </div>
      </div>
    </div>
  </div>

  <h2 class="divider"><div>Social Preview</div></h2>

  <div class="field-wrap">
    <div class="inner">
      <div>
        <div class="facebook-snippet">
          <?php if (!empty($og_image)) { ?>
            <img src="<?php echo $og_image; ?>" alt="<?php echo $og_title; ?>">
          <?php } ?>

          <div class="details">
            <p class="url"><?php echo $og_url; ?></p>
            <h3 class="title"><?php echo $og_title; ?></h3>
            <p class="description"><?php echo $og_description; ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h2 class="divider"><div>Performance</div></h2>

  <div class="field-wrap">
    <div class="inner">
      <div class="panel clearfix">
        <div id="pagescore">
          <div class="pulse" data-status="<?php echo $Seo_PageInsights->get_traffic_light(); ?>">
            <div class="status">
            </div>
          </div>
          <h2><?php echo $Seo_PageInsights->get_title(); ?></h2>
          <p><?php echo $Seo_PageInsights->get_description(); ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
}
?>