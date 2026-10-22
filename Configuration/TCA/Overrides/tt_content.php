<?php
defined('TYPO3') or die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginSignature = 'wokgpxviewer_gpxtracks';

// 1. Inhaltselement/Plugin registrieren
ExtensionUtility::registerPlugin(
    'WokGpxviewer',
    'Gpxtracks',
    'GPXViewer tracks display',
    'EXT:wok_gpxviewer/Resources/Public/Icons/user_plugin_gpxtracks.svg',
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// 2. FlexForm-Datenstruktur direkt an das TCA des Inhaltselements binden (Ersetzt addPiFlexFormValue)
$GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['columnsOverrides']['pi_flexform']['config']['ds'] = [
    'default' => 'FILE:EXT:wok_gpxviewer/Configuration/FlexForms/Gpxtracks.xml',
];

// 3. Dem Inhaltselement mitteilen, dass das pi_flexform-Feld eingeblendet werden soll
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'pi_flexform',
    $pluginSignature,
    'after:palette:headers'
);
