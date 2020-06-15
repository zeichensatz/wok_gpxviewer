<?php
namespace Wok\WokGpxviewer\Tests\Unit\Controller;

/**
 * Test case.
 */
class DisplayControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Wok\WokGpxviewer\Controller\DisplayController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Wok\WokGpxviewer\Controller\DisplayController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
