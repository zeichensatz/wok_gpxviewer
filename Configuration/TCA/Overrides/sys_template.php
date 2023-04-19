<?php

defined('TYPO3') or die('Access denied.');

/***************
 * TypoScript: Full Package
 * This includes the full setup including all configurations
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'wok_gpxviewer', 
    'Configuration/TypoScript', 
    'GPXViewer'
);

