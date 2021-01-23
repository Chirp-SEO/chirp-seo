<?php
# include the API
include('../../../../core/inc/api.php');

$API  = new PerchAPI(1.0, 'chirp_seo');
$HTML   = $API->get('HTML');
$Lang   = $API->get('Lang');
$Paging = $API->get('Paging');

# Set the page title
$Perch->page_title = PerchLang::get('Viewing Collections');

$Perch->add_css($API->app_path('chirp_seo') . '/assets/css/seo.css');
$Perch->add_javascript($API->app_path('chirp_seo') . '/assets/js/app.js');

# Do anything you want to do before output is started
include('../modes/_subnav.php');
include('../modes/collections.list.pre.php');

# Top layout
include(PERCH_CORE . '/inc/top.php');

# Display your page
include('../modes/collections.list.post.php');

# Bottom layout
include(PERCH_CORE . '/inc/btm.php');
