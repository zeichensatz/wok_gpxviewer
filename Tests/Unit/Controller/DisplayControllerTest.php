<?php
declare(strict_types=1);

namespace Wok\WokGpxviewer\Tests\Unit\Controller;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class DisplayControllerTest extends UnitTestCase
{
    /**
     * @var \Wok\WokGpxviewer\Controller\DisplayController
     */
    protected $subject;

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
