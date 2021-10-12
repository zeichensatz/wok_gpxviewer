<?php

declare(strict_types=1);

namespace Wok\WokGpxviewer\Domain\Model;


/***
 *
 * This file is part of the "GPXViewer" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

/**
 * Display
 */
class Display extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * dummy
     *
     * @var string
     */
    protected $dummy = '';

    /**
     * Returns the dummy
     *
     * @return string $dummy
     */
    public function getDummy()
    {
        return $this->dummy;
    }

    /**
     * Sets the dummy
     *
     * @param string $dummy
     * @return void
     */
    public function setDummy($dummy)
    {
        $this->dummy = $dummy;
    }
}
