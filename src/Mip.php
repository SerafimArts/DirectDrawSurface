<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

final class Mip extends Image implements MipInterface
{
    /**
     * @param positive-int|0 $level
     * @param positive-int|0 $width
     * @param positive-int|0 $height
     * @param \Closure(): string $contents
     */
    public function __construct(private int $level, int $width, int $height, private \Closure $contents)
    {
        parent::__construct($width, $height);
    }

    /**
     * @param positive-int|0 $level
     * @param positive-int|0 $width
     * @param positive-int|0 $height
     * @param string $contents
     * @return static
     */
    public static function fromString(int $level, int $width, int $height, string $contents): self
    {
        return new self($level, $width, $height, static fn(): string => $contents);
    }

    /**
     * @return array{level: positive-int|0, width: positive-int|0, height: positive-int|0}
     */
    public function __debugInfo(): array
    {
        return [
            'level'  => $this->level,
            'width'  => $this->width,
            'height' => $this->height,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return ($this->contents)();
    }
}
