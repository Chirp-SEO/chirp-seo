<?php
echo $HTML->title_panel([
'heading' => PerchLang::get("Viewing Analysis for '%s'", PerchUtil::html($Product->title()))
], $CurrentUser);
?>

  <?php if ($error) echo $error; ?>
  <?php if ($message) echo $message; ?>

  <div class="smartbar">
      <ul>
        <li>
          <div class="breadcrumb tab-active">
            <a href="<?php echo PERCH_LOGINPATH . $API->app_nav() . '/'; ?>shop"><?php echo PerchLang::get('Products'); ?></a>
            <?php echo PerchUI::icon('core/o-navigate-right', 8, 'Navigate'); ?>
            <a href="#"><?php echo PerchUtil::html($Product->title()); ?></a>
           </div>
         </li>
          <li>
              <form method="post" class="smartbar-search">
                  <label><?php echo PerchUI::icon('core/o-key', 16, 'Search'); ?>
                      <input name="keywordTitle" type="text" placeholder="Keyword Title" class="search" value="<?php echo $keyword; ?>">
                  </label>
                  <input type="hidden" name="formaction" value="chirp_seo">
                  <input type="hidden" name="token" value="<?php echo $Form->get_token(); ?>">
                  <button class="button button-small action-info">Update</button>
              </form>
          </li>
          <li class="smartbar-end smartbar-util">
            <a href="<?php echo PERCH_LOGINPATH . '/addons/apps/perch_shop_products/product/edit/?id=' . $Product->productID(); ?>" title="Edit Page" class="viewext">
              <?php echo PerchUI::icon('core/document', 16, 'Page'); ?>
              <span>Edit Product</span>
            </a>
          </li>
          <li>
            <a href="<?php echo $product_url; ?>" title="View Page" class="viewext">
              <?php echo PerchUI::icon('core/o-world', 16, 'Page'); ?>
              <span>View Product</span>
            </a>
          </li>
      </ul>
  </div>

<?php include('global.view.post.php'); ?>
