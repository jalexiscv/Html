<?php namespace Config;

use Higgs\Config\BaseConfig;
use Higgs\Images\Handlers\BaseHandler;
use Higgs\Images\Handlers\GDHandler;
use Higgs\Images\Handlers\ImageMagickHandler;

class Images extends BaseConfig
{
    /**
     * Default handler used if no other handler is specified.
     *
     * @var string
     */
    public $defaultHandler = 'gd';

    /**
     * The path to the image library.
     * Required for ImageMagick, GraphicsMagick, or NetPBM.
     *
     * @var string
     */
    public $libraryPath = '/usr/local/bin/convert';

    /**
     * The available handler classes.
     *
     * @var BaseHandler[]
     */
    public $handlers = [
        'gd' => GDHandler::class,
        'imagick' => ImageMagickHandler::class,
    ];
}
