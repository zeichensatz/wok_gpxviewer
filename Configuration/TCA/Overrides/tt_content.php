<?php
defined('TYPO3_MODE') || die();

/***************
 * Register plugin for selection in the backend plugin list
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Wok.WokGpxviewer',
    'Gpxtracks',
    'GPXViewer tracks display',
    'EXT:wok_gpxviewer/Resources/Public/Icons/user_plugin_gpxtracks.svg'
);

/***************
 * Add flexForms for plugin configuration
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['wokgpxviewer_gpxtracks'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'wokgpxviewer_gpxtracks',
    // Flexform configuration schema file
    'FILE:EXT:wok_gpxviewer/Configuration/FlexForms/Gpxtracks.xml'
);

/***************
 * Deactivate pages and recursive in tab "plugin" of content element 
 */
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['wokgpxviewer_gpxtracks'] = 'pages,recursive';
