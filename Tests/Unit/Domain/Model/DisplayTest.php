<?php
declare(strict_types=1);

namespace Wok\WokGpxviewer\Tests\Unit\Domain\Model;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class DisplayTest extends UnitTestCase
{
    /**
     * @var \Wok\WokGpxviewer\Domain\Model\Display
     */
    protected $subject;

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
