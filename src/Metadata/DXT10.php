<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata;

use Serafim\DDS\Metadata\DXT10\AlphaMode;
use Serafim\DDS\Metadata\DXT10\ResourceMiscFlag;
use Serafim\DDS\Metadata\DXT10\DxgiFormat;
use Serafim\DDS\Metadata\DXT10\ResourceDimension;

/**
 * DDS header extension to handle resource arrays, DXGI pixel formats that don't
 * map to the legacy Microsoft DirectDraw pixel format structures, and
 * additional metadata.
 *
 * @link https://docs.microsoft.com/en-us/windows/win32/direct3ddds/dds-header-dxt10
 */
final class DXT10
{
    /**
     * @param DxgiFormat $dxgiFormat                The surface pixel format.
     * @param ResourceDimension $resourceDimension  Identifies the type of resource. The following values for this
     *                                              member are a subset of the values in
     *                                              the {@see ResourceDimension} enumeration.
     * @param ResourceMiscFlag $miscFlag            Identifies other, less common options for resources. The following
     *                                              value for this member is a subset of the values in
     *                                              the {@see ResourceMiscFlag} enumeration:
     *                                                  - {@see ResourceMiscFlag::TEXTURECUBE} - Indicates a 2D texture
     *                                                    is a cube-map texture.
     * @param positive-int|0 $arraySize             The number of elements in the array.
     *                                                  - For a 2D texture that is also a cube-map texture, this number
     *                                                    represents the number of cubes. This number is the same as the
     *                                                    number in the NumCubes member of D3D10_TEXCUBE_ARRAY_SRV1 or
     *                                                    D3D11_TEXCUBE_ARRAY_SRV). In this case, the DDS file contains
     *                                                    arraySize * 6 2D textures. For more information about this
     *                                                    case, see the {@see DXT10::$miscFlag} description.
     *                                                  - For a 3D texture, you must set this number to 1.
     * @param AlphaMode $miscFlags2                 Contains additional metadata (formerly was reserved). The lower 3
     *                                              bits indicate the alpha mode of the associated resource. The upper
     *                                              29 bits are reserved and are typically 0.
     */
    public function __construct(
        public DxgiFormat $dxgiFormat = DxgiFormat::DXGI_FORMAT_UNKNOWN,
        public ResourceDimension $resourceDimension = ResourceDimension::UNKNOWN,
        public ResourceMiscFlag $miscFlag = ResourceMiscFlag::TEXTURECUBE,
        public int $arraySize = 0,
        public AlphaMode $miscFlags2 = AlphaMode::UNKNOWN,
    ) {}
}
