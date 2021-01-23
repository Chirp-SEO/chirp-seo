<?php
echo $HTML->title_panel([
'heading' => PerchLang::get("Viewing Analysis for '%s'", PerchUtil::html($Post->postTitle()))
], $CurrentUser);
?>

  <?php if ($error) echo $error; ?>
  <?php if ($message) echo $message; ?>

  <div class="smartbar">
      <ul>
        <li>
          <div class="breadcrumb tab-active">
            <a href="<?php echo PERCH_LOGINPATH . $API->app_nav() . '/'; ?>blog"><?php echo PerchLang::get('Posts'); ?></a>
            <?php echo PerchUI::icon('core/o-navigate-right', 8, 'Navigate'); ?>
            <a href="#"><?php echo PerchUtil::html($Post->postTitle()); ?></a>
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
            <a href="<?php echo PERCH_LOGINPATH . '/addons/apps/perch_blog/edit/?id=' . $Post->postID(); ?>" title="Edit Page" class="viewext">
              <?php echo PerchUI::icon('core/document', 16, 'Page'); ?>
              <span>Edit Post</span>
            </a>
          </li>
          <li>
            <a href="<?php echo $snippet_url; ?>" title="View Page" class="viewext">
              <?php echo PerchUI::icon('core/o-world', 16, 'Page'); ?>
              <span>View Post</span>
            </a>
          </li>
      </ul>
  </div>


  <?php include('global.view.post.php'); ?>