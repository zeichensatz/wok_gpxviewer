<?php
defined('TYPO3') || die('Access denied.');

use Wok\WokGpxviewer\Controller\DisplayController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function() {
    // Registrierung als eigenständiges Inhaltselement (Zukunftssicher für TYPO3 13/14)
    ExtensionUtility::configurePlugin(
        'WokGpxviewer',
        'Gpxtracks',
        [
            DisplayController::class => 'index'
        ],
        // non-cacheable actions
        [
            DisplayController::class => 'index'
        ],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT // 5. Parameter hinzugefügt
    );
})();
