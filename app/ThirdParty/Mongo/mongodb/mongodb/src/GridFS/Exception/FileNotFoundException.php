<?php

namespace MongoDB\GridFS\Exception;

use MongoDB\Exception\RuntimeException;
use function MongoDB\BSON\fromPHP;
use function MongoDB\BSON\toJSON;
use function sprintf;

class FileNotFoundException extends RuntimeException
{
    public static function byFilenameAndRevision(string $filename, int $revision, string $namespace)
    {
        return new static(sprintf('File with name "%s" and revision "%d" not found in "%s"', $filename, $revision, $namespace));
    }

    public static function byId($id, string $namespace)
    {
        $json = toJSON(fromPHP(['_id' => $id]));
        return new static(sprintf('File "%s" not found in "%s"', $json, $namespace));
    }
}