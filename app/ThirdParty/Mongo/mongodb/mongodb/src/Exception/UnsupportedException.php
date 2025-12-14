<?php

namespace MongoDB\Exception;
class UnsupportedException extends RuntimeException
{
    public static function allowDiskUseNotSupported()
    {
        return new static('The "allowDiskUse" option is not supported by the server executing this operation');
    }

    public static function arrayFiltersNotSupported()
    {
        return new static('Array filters are not supported by the server executing this operation');
    }

    public static function collationNotSupported()
    {
        return new static('Collations are not supported by the server executing this operation');
    }

    public static function commitQuorumNotSupported()
    {
        return new static('The "commitQuorum" option is not supported by the server executing this operation');
    }

    public static function explainNotSupported()
    {
        return new static('Explain is not supported by the server executing this operation');
    }

    public static function hintNotSupported()
    {
        return new static('Hint is not supported by the server executing this operation');
    }

    public static function readConcernNotSupported()
    {
        return new static('Read concern is not supported by the server executing this command');
    }

    public static function readConcernNotSupportedInTransaction()
    {
        return new static('The "readConcern" option cannot be specified within a transaction. Instead, specify it when starting the transaction.');
    }

    public static function writeConcernNotSupported()
    {
        return new static('Write concern is not supported by the server executing this command');
    }

    public static function writeConcernNotSupportedInTransaction()
    {
        return new static('The "writeConcern" option cannot be specified within a transaction. Instead, specify it when starting the transaction.');
    }
}