<?php
defined('TYPO3') or die('Access denied.');

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginSignature = 'wokgpxviewer_gpxtracks';

// 1. Plugin registrieren
ExtensionUtility::registerPlugin(
    'WokGpxviewer',
    'Gpxtracks',
    'GPXViewer tracks display',
    'EXT:wok_gpxviewer/Resources/Public/Icons/user_plugin_gpxtracks.svg',
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// 2. Das pi_flexform-Feld sicher in das Standard-TCA einbetten
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'pi_flexform',
    $pluginSignature,
    'after:palette:headers'
);

// 3. FlexForm-Datenstruktur über die offizielle API an die Signatur koppeln
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:wok_gpxviewer/Configuration/FlexForms/Gpxtracks.xml',
    $pluginSignature
);
