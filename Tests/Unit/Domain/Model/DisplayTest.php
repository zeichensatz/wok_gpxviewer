<?php
namespace Wok\WokGpxviewer\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class DisplayTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
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
    public function getDummyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDummy()
        );
    }

    /**
     * @test
     */
    public function setDummyForStringSetsDummy()
    {
        $this->subject->setDummy('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'dummy',
            $this->subject
        );
    }
}
