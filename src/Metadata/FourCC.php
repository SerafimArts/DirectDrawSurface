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
    case ATI1 = 'ATI1';
    case ATI2 = 'ATI2';
    case BC4U = 'BC4U';
    case BC4S = 'BC4S';
    case BC5U = 'BC5U';
    case BC5S = 'BC5S';
    case RGBG = 'RGBG';
    case GRGB = 'GRGB';
    case YUY2 = 'YUY2';
}
