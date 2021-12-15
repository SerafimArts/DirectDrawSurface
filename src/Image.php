<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

abstract class Image implements ImageInterface
{
    /**
     * @param positive-int|0 $width
     * @param positive-int|0 $height
     */
    public function __construct(
        public int $width = 0,
        public int $height = 0,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight(): int
    {
        return $this->height;
    }
}
