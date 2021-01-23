<?php
include(__DIR__ . '/_version.php');

$this->register_app('chirp_seo', 'SEO', '1', 'SEO analysis', CHIRP_SEO_VERSION);
$this->require_version('chirp_seo', '3.0');
$this->add_create_page('chirp_seo', 'edit');
$this->add_setting('chirp_seo_sitemap_url', 'Chirp Sitemap Location', 'text', false);
$this->add_setting('chirp_seo_twitter_handler', 'Chirp Twitter Handle', 'text', false);

require "lib/vendor/autoload.php";

spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'ChirpSeo_') === 0) {
        include(PERCH_PATH . '/addons/apps/chirp_seo/lib/' . $class_name . '.class.php');
        return true;
    }
    return false;
});

include_once(__DIR__ . '/fieldtypes.php');

$API  = new PerchAPI(1.0, 'chirp_seo');
