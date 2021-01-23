<div class="inner">
  <div style="update-box">
    <div class="hd">
        <h1>Chirp Software Update</h1>
    </div>

    <div class="bd">
        <ul class="progress-list">
    <?php
        echo '<li class="progress-item progress-success">'.PerchUI::icon('core/circle-check').' Updated to version '.CHIRP_SEO_VERSION.'.</li>';

    ?>
      </ul>
    </div>
    <div class="submit">
      <a href="<?php echo $API->app_path('chirp_seo'); ?>" class="button button-simple action-success">Continue</a>
    </div>
  </div>
</div>