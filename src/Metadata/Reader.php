<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS\Metadata;

use Serafim\BinStream\Reader as StreamReader;
use Serafim\BinStream\Type\ArrayType;
use Serafim\BinStream\Type\FlagsType;
use Serafim\BinStream\Type\StringType;
use Serafim\BinStream\Type\UInt32Type;
use Serafim\DDS\Metadata;
use Serafim\DDS\Metadata\DXT10\AlphaMode;
use Serafim\DDS\Metadata\DXT10\ResourceMiscFlag;
use Serafim\DDS\Metadata\DXT10\DxgiFormat;
use Serafim\DDS\Metadata\DXT10\ResourceDimension;
use Serafim\DDS\Metadata\Header\Capability;
use Serafim\DDS\Metadata\Header\Capability2;
use Serafim\DDS\Metadata\Header\Flag as HeaderFlag;
use Serafim\DDS\Metadata\PixelFormat\Flag as PixelFormatFlag;

/**
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Serafim\DDS\Metadata
 */
final class Reader
{
    /**
     * A DWORD (magic number) containing the four character code
     * value "DDS " (0x20534444).
     *
     * @link https://docs.microsoft.com/en-us/windows/win32/direct3ddds/dx-graphics-dds-pguide#dds-file-layout
     * @var non-empty-string
     */
    public const HEADER_MAGICK = 'DDS ';

    /**
     * @param StreamReader $stream
     * @return Metadata
     * @throws \Throwable
     */
    public function read(StreamReader $stream): Metadata
    {
        if ($stream->string(4) !== self::HEADER_MAGICK) {
            throw new \InvalidArgumentException('Passed data is not a valid DDS image');
        }

        $header = $this->readHeader($stream);

        if ($header->format->fourCC === FourCC::DX10) {
            $dxt10 = $this->readDXT10Header($stream);
        }

        return new Metadata(
            header: $header,
            dxt10: $dxt10 ?? null,
            offset: $stream->offset(),
        );
    }

    /**
     * @param StreamReader $stream
     * @return DXT10
     * @throws \Throwable
     */
    private function readDXT10Header(StreamReader $stream): DXT10
    {
        return new DXT10(
            dxgiFormat: $stream->enum(DxgiFormat::class, UInt32Type::class),
            resourceDimension: $stream->enum(ResourceDimension::class, UInt32Type::class),
            miscFlag: $stream->enum(ResourceMiscFlag::class, UInt32Type::class),
            arraySize: $stream->uint32(),
            miscFlags2: $stream->enum(AlphaMode::class, UInt32Type::class),
        );
    }

    /**
     * @param StreamReader $stream
     * @return Header
     * @throws \Throwable
     */
    private function readHeader(StreamReader $stream): Header
    {
        return new Header(
            size: $stream->uint32(),
            flags: $stream->readAs(new FlagsType(HeaderFlag::class, UInt32Type::class)),
            height: $stream->uint32(),
            width: $stream->uint32(),
            pitchOrLinearSize: $stream->uint32(),
            depth: $stream->uint32(),
            mipMapCount: $stream->uint32(),
            reserved1: $stream->readAs(new ArrayType(UInt32Type::class, 11)),
            format: $this->readPixelFormat($stream),
            caps: $stream->readAs(new FlagsType(Capability::class, UInt32Type::class)),
            caps2: $stream->readAs(new FlagsType(Capability2::class, UInt32Type::class)),
            reserved2: $stream->readAs(new ArrayType(UInt32Type::class, 3)),
        );
    }

    /**
     * @param StreamReader $stream
     * @return PixelFormat
     * @throws \Throwable
     */
    private function readPixelFormat(StreamReader $stream): PixelFormat
    {
        return new PixelFormat(
            size: $stream->uint32(),
            flags: $stream->readAs(new FlagsType(PixelFormatFlag::class, UInt32Type::class)),
            fourCC: $stream->enum(FourCC::class, new StringType(4)),
            rgbBitCount: $stream->uint32(),
            rBitMask: $stream->uint32(),
            gBitMask: $stream->uint32(),
            bBitMask: $stream->uint32(),
            aBitMask: $stream->uint32()
        );
    }
}
