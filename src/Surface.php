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

class Surface extends Image implements SurfaceInterface
{
    /**
     * @param Metadata $meta
     * @param array<MipInterface> $mips
     */
    public function __construct(
        public Metadata $meta,
        private array $mips = [],
    ) {
        parent::__construct($meta->header->width, $meta->header->height);
    }

    /**
     * @return array{header: Header, mips: list<Mip>}
     */
    public function __debugInfo(): array
    {
        return [
            'meta' => $this->meta,
            'mips' => $this->mips,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->mips);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return \count($this->mips);
    }
}
