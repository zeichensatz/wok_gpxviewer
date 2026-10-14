<?php
namespace Wok\WokGpxviewer\ViewHelpers;

use TYPO3\CMS\Core\Page\AssetCollector;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GpxviewerSettingsViewHelper extends AbstractViewHelper 
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('jsSettings', 'string', 'Javascript settings for GPXViewer', true);
    }

    public function render(): void
    {
        $jsSettings = $this->arguments['jsSettings'];

        if (!empty($jsSettings)) {
            $assetCollector = GeneralUtility::makeInstance(AssetCollector::class);
            $assetCollector->addInlineJavaScript(
                'Settings-for-GPXViewer',
                $jsSettings,
                [],
                ['priority' => false] // priority false sorgt für Platzierung im Footer
            );
        }
    }
}
