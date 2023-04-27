<?php
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') || die();

// Condition for TYPO3 < 12 as it is done in news extension from Georg Ringer
$boot = static function (): void {
    $versionInformation = GeneralUtility::makeInstance(Typo3Version::class);
    if ($versionInformation->getMajorVersion() < 12) {
        // @extensionScannerIgnoreLine
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wokgpxviewer_domain_model_display', 'EXT:wok_gpxviewer/Resources/Private/Language/locallang_csh_tx_wokgpxviewer_domain_model_display.xlf');
        // @extensionScannerIgnoreLine
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wokgpxviewer_domain_model_display');
    };
};
$boot();
unset($boot);
