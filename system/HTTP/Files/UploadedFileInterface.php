<?php

namespace Higgs\HTTP\Files;

use InvalidArgumentException;
use RuntimeException;

interface UploadedFileInterface
{
    public function __construct(string $path, string $originalName, ?string $mimeType = null, ?int $size = null, ?int $error = null);

    public function move(string $targetPath, ?string $name = null);

    public function hasMoved(): bool;

    public function getError(): int;

    public function getName(): string;

    public function getTempName(): string;

    public function getClientExtension(): string;

    public function getClientMimeType(): string;

    public function isValid(): bool;

    public function getDestination(string $destination, string $delimiter = '_', int $i = 0): string;
}