<?php

declare(strict_types=1);

namespace DH\Adf\Node\Child;

use DH\Adf\Node\BlockNode;
use DH\Adf\Node\Node;
use InvalidArgumentException;

/**
 * @see https://developer.atlassian.com/cloud/jira/platform/apis/document/nodes/media
 */
class Media extends Node
{
    public const TYPE_FILE = 'file';
    public const TYPE_LINK = 'link';

    protected string $type = 'media';
    private string $id;
    private string $mediaType;
    private string $collection;
    private ?string $occurrenceKey;
    private ?string $alt;
    private ?int $width;
    private ?int $height;

    public function __construct(string $id, string $mediaType, string $collection, ?int $width = null, ?int $height = null, ?string $occurrenceKey = null, ?BlockNode $parent = null, ?string $alt = null)
    {
        if (!\in_array($mediaType, [self::TYPE_FILE, self::TYPE_LINK], true)) {
            throw new InvalidArgumentException('Invalid media type');
        }

        parent::__construct($parent);
        $this->id = $id;
        $this->mediaType = $mediaType;
        $this->collection = $collection;
        $this->occurrenceKey = $occurrenceKey;
        $this->width = $width;
        $this->height = $height;
        $this->alt = $alt;
    }

    public static function load(array $data, ?BlockNode $parent = null): self
    {
        self::checkNodeData(static::class, $data, ['attrs']);
        self::checkRequiredKeys(['id', 'type', 'collection'], $data['attrs']);

        return new self(
            $data['attrs']['id'],
            $data['attrs']['type'],
            $data['attrs']['collection'],
            $data['attrs']['width'] ?? null,
            $data['attrs']['height'] ?? null,
            $data['attrs']['occurrenceKey'] ?? null,
            $parent,
            $data['attrs']['alt'] ?? null
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getCollection(): string
    {
        return $this->collection;
    }

    public function getOccurrenceKey(): ?string
    {
        return $this->occurrenceKey;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getAlt(): ?int
    {
        return $this->alt;
    }

    protected function attrs(): array
    {
        $attrs = parent::attrs();

        $attrs['id'] = $this->id;
        $attrs['type'] = $this->mediaType;
        $attrs['collection'] = $this->collection;

        if (null !== $this->occurrenceKey) {
            $attrs['occurrenceKey'] = $this->occurrenceKey;
        }

        if (null !== $this->width) {
            $attrs['width'] = $this->width;
        }

        if (null !== $this->height) {
            $attrs['height'] = $this->height;
        }

        if (null !== $this->alt) {
            $attrs['alt'] = $this->alt;
        }

        return $attrs;
    }
}
