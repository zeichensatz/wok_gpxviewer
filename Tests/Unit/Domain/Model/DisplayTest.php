<?php
namespace Wok\WokGpxviewer\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class DisplayTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Wok\WokGpxviewer\Domain\Model\Display
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Wok\WokGpxviewer\Domain\Model\Display();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
