<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata\PixelFormat;

enum Flag: int
{
    /**
     * Texture contains alpha data;
     */
    case ALPHA_PIXELS = 0x00000001;

    /**
     * Used in some older DDS files for alpha channel only uncompressed data:
     *  - {@see PixelFormat::$rgbBitCount} contains the alpha channel bitcount.
     *  - {@see PixelFormat::$aBitMask} contains valid data.
     */
    case ALPHA = 0x00000002;

    /**
     * Texture contains compressed RGB data;
     *  - {@see PixelFormat::$fourCC} contains valid data.
     */
    case FOURCC = 0x00000004;

    /**
     * Texture contains uncompressed RGB data; {@see PixelFormat::$rgbBitCount}
     * and the RGB masks:
     *  - {@see PixelFormat::$rBitMask}
     *  - {@see PixelFormat::$gBitMask}
     *  - {@see PixelFormat::$bBitMask}
     * contain valid data.
     */
    case RGB = 0x00000040;

    /**
     * Used in some older DDS files for YUV uncompressed data:
     *  - {@see PixelFormat::$rgbBitCount} contains the YUV bit count.
     *  - {@see PixelFormat::$rBitMask} contains the Y mask.
     *  - {@see PixelFormat::$gBitMask} contains the U mask.
     *  - {@see PixelFormat::$bBitMask} contains the V mask.
     */
    case YUV = 0x00000200;

    /**
     * Used in some older DDS files for single channel color uncompressed data:
     *  - {@see PixelFormat::$rgbBitCount} contains the luminance channel bit count.
     *  - {@see PixelFormat::rBitMask} contains the channel mask.
     *
     * Can be combined with {@see Flag::ALPHA_PIXELS} for a two
     * channel DDS file.
     */
    case LUMINANCE = 0x00020000;
}
