<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

interface ImageInterface
{
    /**
     * @return positive-int|0
     */
    public function getWidth(): int;

    /**
     * @return positive-int|0
     */
    public function getHeight(): int;
}
