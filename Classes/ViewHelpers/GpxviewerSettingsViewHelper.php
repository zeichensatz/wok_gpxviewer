<?php
namespace Wok\WokGpxviewer\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GpxviewerSettingsViewHelper extends AbstractViewHelper {
	use CompileWithRenderStatic;
	
	protected $escapeOutput = false;

	public function initializeArguments()
	{
		$this->registerArgument('jsSettings', 'string', 'Javascript settings for GPXViewer', true);
	}

	/**
	 * @param array $arguments
	 * @param \Closure $renderChildrenClosure
	 * @param RenderingContextInterface $renderingContext
	**/
	public static function renderStatic(
		array $arguments,
		\Closure $renderChildrenClosure,
		RenderingContextInterface $renderingContext
	) {
		$jsSettings = $arguments['jsSettings'];
		$compress = "false";
		$onTop = "false";

		$pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
		$pageRenderer->addJsFooterInlineCode("Settings for GPXViewer", $jsSettings, $compress, $onTop);
	}
}
