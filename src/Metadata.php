<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

use Serafim\DDS\Metadata\Header;
use Serafim\DDS\Metadata\DXT10;
use Serafim\DDS\Metadata\Header\Capability;

final class Metadata
{
    /**
     * @param Header $header
     * @param DXT10|null $dxt10
     * @param positive-int|0 $offset
     */
    public function __construct(
        public readonly Header $header = new Header(),
        public readonly ?DXT10 $dxt10 = null,
        public readonly int $offset = 0,
    ) {}

    /**
     * @return bool
     */
    public function hasMips(): bool
    {
        return $this->header->mipMapCount > 0 && $this->header->hasCapability(Capability::MIPMAP);
    }
}
