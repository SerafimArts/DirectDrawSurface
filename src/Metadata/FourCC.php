<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata;

enum FourCC: string
{
    case DXT1 = 'DXT1';
    case DXT2 = 'DXT2';
    case DXT3 = 'DXT3';
    case DXT4 = 'DXT4';
    case DXT5 = 'DXT5';
    case DX10 = 'DX10';

    /**
     * @return bool
     */
    public function isCompressed(): bool
    {
        return $this === self::DXT1
            || $this === self::DXT3
            || $this === self::DXT5
        ;
    }
}
