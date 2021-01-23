<?php

  if (!defined('PERCH_DB_PREFIX')) exit;

  $db = $API->get('DB');

  $sql = "ALTER TABLE `".PERCH_DB_PREFIX."chirp_seo` ADD COLUMN `keywordURL` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' after `keywordTitle`";
  $db->execute($sql);

  $sql = "ALTER TABLE `".PERCH_DB_PREFIX."chirp_seo` ADD COLUMN `keywordPageID` int(11) after `keywordURL`";
  $db->execute($sql);

  $sql = "ALTER TABLE `".PERCH_DB_PREFIX."chirp_seo` ADD COLUMN `keywordBlogID` int(11) after `keywordPageID`";
  $db->execute($sql);

  $sql = "TRUNCATE TABLE `".PERCH_DB_PREFIX."chirp_seo_scores`";
  $db->execute($sql);
	    
  $sql = "
    CREATE TABLE IF NOT EXISTS `__PREFIX__chirp_seo_scores` (
      `scoreID` int(11) NOT NULL AUTO_INCREMENT,
      `url` varchar(255) NOT NULL DEFAULT '',
      `readabilityScore` int(11) DEFAULT NULL,
      `seoScore` int(11) DEFAULT NULL,
      `pagespeedScore` int(11) DEFAULT NULL,
      PRIMARY KEY (`scoreID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
    ";

  $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
  
  $db->execute($sql);

  $Settings->set('chirp_update', CHIRP_SEO_VERSION);