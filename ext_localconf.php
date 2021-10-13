<?php
defined('TYPO3_MODE') || die();

call_user_func(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'WokGpxviewer',
        'Gpxtracks',
        [
            \Wok\WokGpxviewer\Controller\DisplayController::class => 'index'
        ],
        // non-cacheable actions
        [
            \Wok\WokGpxviewer\Controller\DisplayController::class => 'index'
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    gpxtracks {
                        iconIdentifier = wok_gpxviewer-plugin-gpxtracks
                        title = LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang_db.xlf:tx_wok_gpxviewer_gpxtracks.name
                        description = LLL:EXT:wok_gpxviewer/Resources/Private/Language/locallang_db.xlf:tx_wok_gpxviewer_gpxtracks.description
                        tt_content_defValues {
                            CType = list
                            list_type = wokgpxviewer_gpxtracks
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'wok_gpxviewer-plugin-gpxtracks',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:wok_gpxviewer/Resources/Public/Icons/user_plugin_gpxtracks.svg']
    );
});
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder