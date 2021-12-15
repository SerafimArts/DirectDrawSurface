<?php

/**
 * This file is part of DDS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\DDS;

use Serafim\BinStream\Reader as StreamReader;
use Serafim\BinStream\Stream\ReadableResourceStream;
use Serafim\BinStream\Stream\ReadableStreamInterface;
use Serafim\BinStream\Type\Repository;
use Serafim\DDS\Metadata\DXT10\DxgiFormat;
use Serafim\DDS\Metadata\FourCC;
use Serafim\DDS\Metadata\Header;
use Serafim\DDS\Metadata\Reader as MetadataReader;

final class Reader implements ReaderInterface
{
    /**
     * @var MetadataReader
     */
    private readonly MetadataReader $meta;

    /**
     * Reader constructor.
     */
    public function __construct()
    {
        $this->meta = new MetadataReader();
    }

    /**
     * @param string $data
     * @return SurfaceInterface
     */
    public function fromString(string $data): SurfaceInterface
    {
        $memory = \fopen('php://memory', 'rb+');
        \fwrite($memory, $data);
        \fseek($memory, 0);

        return $this->fromResource($memory);
    }

    /**
     * {@inheritDoc}
     */
    public function fromPathname(string $pathname): SurfaceInterface
    {
        return $this->fromResource(
            \fopen($pathname, 'rb')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function fromResource(mixed $stream): SurfaceInterface
    {
        return $this->fromReadableStream(
            new ReadableResourceStream($stream)
        );
    }

    /**
     * @param ReadableStreamInterface $stream
     * @return SurfaceInterface
     * @throws \Throwable
     */
    private function fromReadableStream(ReadableStreamInterface $stream): SurfaceInterface
    {
        $stream = new StreamReader($stream);

        $meta = $this->meta->read($stream);

        return new Surface($meta, \iterator_to_array($this->readMips($meta, $stream), false));
    }

    /**
     * @param Metadata $meta
     * @param StreamReader $stream
     * @return \Traversable<MipInterface>
     */
    private function readMips(Metadata $meta, StreamReader $stream): \Traversable
    {
        if (! $meta->hasMips()) {
            return [];
        }

        [$width, $height] = [$meta->header->width, $meta->header->height];

        for ($level = 0; $level < $meta->header->mipMapCount && ($width || $height); ++$level) {
            [$width, $height] = [\max($width, 1), \max($height, 1)];

            $size = $this->getMipSize($meta, $width, $height);
            $offset = $stream->offset();

            yield new Mip($level, $width, $height, static function () use ($stream, $size, $offset): string {
                $stream->seek($offset);

                return $stream->read($size);
            });

            $width >>= 1;
            $height >>= 1;
        }
    }

    /**
     * @param Metadata $meta
     * @param positive-int $width
     * @param positive-int $height
     * @return positive-int
     */
    private function getMipSize(Metadata $meta, int $width, int $height): int
    {
        $blockSize = $this->getBlockSize($meta);

        if ($meta->header->format->fourCC->isCompressed()) {
            return (int)((($width + 3) >> 2) * (($height + 3) >> 2) * $blockSize);
        }

        return (int)($width * $height * $blockSize);
    }

    /**
     * @param Metadata $meta
     * @return positive-int
     */
    private function getBlockSize(Metadata $meta): int
    {
        if ($meta->header->format->fourCC === FourCC::DX10) {
            return match ($meta->dxt10->dxgiFormat) {
                DxgiFormat::DXGI_FORMAT_BC1_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC1_UNORM,
                DxgiFormat::DXGI_FORMAT_BC1_UNORM_SRGB,
                DxgiFormat::DXGI_FORMAT_BC4_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC4_UNORM,
                DxgiFormat::DXGI_FORMAT_BC4_SNORM => 8,

                DxgiFormat::DXGI_FORMAT_BC2_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC2_UNORM,
                DxgiFormat::DXGI_FORMAT_BC2_UNORM_SRGB,
                DxgiFormat::DXGI_FORMAT_BC3_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC3_UNORM,
                DxgiFormat::DXGI_FORMAT_BC3_UNORM_SRGB,
                DxgiFormat::DXGI_FORMAT_BC5_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC5_UNORM,
                DxgiFormat::DXGI_FORMAT_BC5_SNORM,
                DxgiFormat::DXGI_FORMAT_BC6H_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC6H_UF16,
                DxgiFormat::DXGI_FORMAT_BC6H_SF16,
                DxgiFormat::DXGI_FORMAT_BC7_TYPELESS,
                DxgiFormat::DXGI_FORMAT_BC7_UNORM,
                DxgiFormat::DXGI_FORMAT_BC7_UNORM_SRGB => 16,

                default => throw new \InvalidArgumentException(
                    'Unsupported DXGI format [' . $meta->dxt10->dxgiFormat->name . ']'
                ),
            };
        }

        return match ($meta->header->format->fourCC) {
            FourCC::DXT1 => 8,
            FourCC::DXT3, FourCC::DXT5 => 16,
            default => throw new \InvalidArgumentException(
                'Unsupported DDS format [' . $meta->header->format->fourCC->name . ']'
            ),
        };
    }
}
