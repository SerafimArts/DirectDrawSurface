<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

interface ReaderInterface
{
    /**
     * @param non-empty-string $pathname
     * @return SurfaceInterface
     */
    public function fromPathname(string $pathname): SurfaceInterface;

    /**
     * @param string $data
     * @return SurfaceInterface
     */
    public function fromString(string $data): SurfaceInterface;

    /**
     * @param resource $stream
     * @return SurfaceInterface
     */
    public function fromResource(mixed $stream): SurfaceInterface;
}
