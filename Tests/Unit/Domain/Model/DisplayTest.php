<?php
declare(strict_types=1);

namespace Wok\WokGpxviewer\Tests\Unit\Domain\Model;

use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\AccessibleObjectInterface;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case
 */
class DisplayTest extends UnitTestCase
{
    /**
     * @var \Wok\WokGpxviewer\Domain\Model\Display|MockObject|AccessibleObjectInterface
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subject = $this->getAccessibleMock(
            \Wok\WokGpxviewer\Domain\Model\Display::class,
            ['dummy']
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDummyReturnsInitialValueForString(): void
    {
        self::assertSame(
            '',
            $this->subject->getDummy()
        );
    }

    /**
     * @test
     */
    public function setDummyForStringSetsDummy(): void
    {
        $this->subject->setDummy('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->_get('dummy'));
    }
}
