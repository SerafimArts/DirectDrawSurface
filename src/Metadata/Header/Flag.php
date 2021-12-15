<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata\Header;

enum Flag: int
{
    /**
     * Required in every .dds file.
     */
    case CAPS = 0x00000001;

    /**
     * Required in every .dds file.
     */
    case HEIGHT = 0x00000002;

    /**
     * Required in every .dds file.
     */
    case WIDTH = 0x00000004;

    /**
     * Required when pitch is provided for an uncompressed texture.
     */
    case PITCH = 0x00000008;

    /**
     * Required in every .dds file.
     */
    case PIXEL_FORMAT = 0x00001000;

    /**
     * Required in a mipmapped texture.
     */
    case MIPMAP_COUNT = 0x00020000;

    /**
     * Required when pitch is provided for a compressed texture.
     */
    case LINEAR_SIZE = 0x00080000;

    /**
     * Required in a depth texture.
     */
    case DEPTH = 0x00800000;
}
