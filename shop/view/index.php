<?php
include('../../../../../core/inc/api.php');
$API  = new PerchAPI(1.0, 'chirp_seo');
$Lang = $API->get('Lang');
$HTML = $API->get('HTML');
$Perch->page_title = PerchLang::get('Analysis') . ' - ' . PerchLang::get('Chirp SEO');

$Perch->add_css($API->app_path('chirp_seo') . '/assets/css/seo.css');
$Perch->add_javascript($API->app_path('chirp_seo') . '/assets/js/app.js');

include('../../modes/_subnav.php');
include('../../modes/shop.view.pre.php');

include(PERCH_CORE . '/inc/top.php');

include('../../modes/shop.view.post.php');

include(PERCH_CORE . '/inc/btm.php');
