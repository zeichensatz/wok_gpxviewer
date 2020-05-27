<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Wok.WokGpxviewer',
            'Gpxtracks',
            [
                'Display' => 'index'
            ],
            // non-cacheable actions
            [
                'Display' => 'index'
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
		
    }
);
