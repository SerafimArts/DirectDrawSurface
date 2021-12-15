<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata\Header;

enum Capability: int
{
    /**
     * Optional; Must be used on any file that contains more than one
     * surface (a mipmap, a cubic environment map, or mipmapped volume texture).
     */
    case COMPLEX = 0x00000008;

    /**
     * Optional; Should be used for a mipmap.
     */
    case MIPMAP  = 0x00400000;

    /**
     * Required.
     */
    case TEXTURE = 0x00001000;
}
