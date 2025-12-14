<?php

namespace Higgs\Images\Handlers;

use Higgs\I18n\Time;
use Higgs\Images\Exceptions\ImageException;
use Config\Images;
use Exception;
use Imagick;

class ImageMagickHandler extends BaseHandler
{
    protected $resource;

    public function __construct($config = null)
    {
        parent::__construct($config);
        if (!(extension_loaded('imagick') || class_exists(Imagick::class))) {
            throw ImageException::forMissingExtension('IMAGICK');
        }
    }

    public function _resize(bool $maintainRatio = false)
    {
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $escape = '\\';
        if (PHP_OS_FAMILY === 'Windows') {
            $escape = '';
        }
        $action = $maintainRatio === true ? ' -resize ' . ($this->width ?? 0) . 'x' . ($this->height ?? 0) . ' "' . $source . '" "' . $destination . '"' : ' -resize ' . ($this->width ?? 0) . 'x' . ($this->height ?? 0) . "{$escape}! \"" . $source . '" "' . $destination . '"';
        $this->process($action);
        return $this;
    }

    protected function getResourcePath()
    {
        if ($this->resource !== null) {
            return $this->resource;
        }
        $this->resource = WRITEPATH . 'cache/' . Time::now()->getTimestamp() . '_' . bin2hex(random_bytes(10)) . '.png';
        $name = basename($this->resource);
        $path = pathinfo($this->resource, PATHINFO_DIRNAME);
        $this->image()->copy($path, $name);
        return $this->resource;
    }

    protected function process(string $action, int $quality = 100): array
    {
        if (empty($this->config->libraryPath)) {
            throw ImageException::forInvalidImageLibraryPath($this->config->libraryPath);
        }
        if ($action !== '-version') {
            $this->supportedFormatCheck();
        }
        if (!preg_match('/convert$/i', $this->config->libraryPath)) {
            $this->config->libraryPath = rtrim($this->config->libraryPath, '/') . '/convert';
        }
        $cmd = $this->config->libraryPath;
        $cmd .= $action === '-version' ? ' ' . $action : ' -quality ' . $quality . ' ' . $action;
        $retval = 1;
        $output = [];
        if (function_usable('exec')) {
            @exec($cmd, $output, $retval);
        }
        if ($retval > 0) {
            throw ImageException::forImageProcessFailed();
        }
        return $output;
    }

    protected function supportedFormatCheck()
    {
        switch ($this->image()->imageType) {
            case IMAGETYPE_WEBP:
                if (!in_array('WEBP', Imagick::queryFormats(), true)) {
                    throw ImageException::forInvalidImageCreate(lang('images.webpNotSupported'));
                }
                break;
        }
    }

    public function _crop()
    {
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $extent = ' ';
        if ($this->xAxis >= $this->width || $this->yAxis > $this->height) {
            $extent = ' -background transparent -extent ' . ($this->width ?? 0) . 'x' . ($this->height ?? 0) . ' ';
        }
        $action = ' -crop ' . ($this->width ?? 0) . 'x' . ($this->height ?? 0) . '+' . ($this->xAxis ?? 0) . '+' . ($this->yAxis ?? 0) . $extent . escapeshellarg($source) . ' ' . escapeshellarg($destination);
        $this->process($action);
        return $this;
    }

    public function getVersion(): string
    {
        $result = $this->process('-version');
        preg_match('/(ImageMagick\s[\S]+)/', $result[0], $matches);
        return str_replace('ImageMagick ', '', $matches[0]);
    }

    public function save(?string $target = null, int $quality = 90): bool
    {
        $original = $target;
        $target = empty($target) ? $this->image()->getPathname() : $target;
        if (empty($this->resource) && $quality === 100) {
            if ($original === null) {
                return true;
            }
            $name = basename($target);
            $path = pathinfo($target, PATHINFO_DIRNAME);
            return $this->image()->copy($path, $name);
        }
        $this->ensureResource();
        $action = escapeshellarg($this->resource) . ' ' . escapeshellarg($target);
        $this->process($action, $quality);
        unlink($this->resource);
        return true;
    }

    protected function ensureResource()
    {
        $this->getResourcePath();
        $this->supportedFormatCheck();
    }

    public function _getWidth()
    {
        return imagesx(imagecreatefromstring(file_get_contents($this->resource)));
    }

    public function _getHeight()
    {
        return imagesy(imagecreatefromstring(file_get_contents($this->resource)));
    }

    public function reorient(bool $silent = false)
    {
        $orientation = $this->getEXIF('Orientation', $silent);
        switch ($orientation) {
            case 2:
                return $this->flip('horizontal');
            case 3:
                return $this->rotate(180);
            case 4:
                return $this->rotate(180)->flip('horizontal');
            case 5:
                return $this->rotate(90)->flip('horizontal');
            case 6:
                return $this->rotate(90);
            case 7:
                return $this->rotate(270)->flip('horizontal');
            case 8:
                return $this->rotate(270);
            default:
                return $this;
        }
    }

    protected function _rotate(int $angle)
    {
        $angle = '-rotate ' . $angle;
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $action = ' ' . $angle . ' ' . escapeshellarg($source) . ' ' . escapeshellarg($destination);
        $this->process($action);
        return $this;
    }

    protected function _flatten(int $red = 255, int $green = 255, int $blue = 255)
    {
        $flatten = "-background 'rgb({$red},{$green},{$blue})' -flatten";
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $action = ' ' . $flatten . ' ' . escapeshellarg($source) . ' ' . escapeshellarg($destination);
        $this->process($action);
        return $this;
    }

    protected function _flip(string $direction)
    {
        $angle = $direction === 'horizontal' ? '-flop' : '-flip';
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $action = ' ' . $angle . ' ' . escapeshellarg($source) . ' ' . escapeshellarg($destination);
        $this->process($action);
        return $this;
    }

    protected function _text(string $text, array $options = [])
    {
        $cmd = '';
        if ($options['vAlign'] === 'bottom') {
            $options['vOffset'] = $options['vOffset'] * -1;
        }
        if ($options['hAlign'] === 'right') {
            $options['hOffset'] = $options['hOffset'] * -1;
        }
        if (!empty($options['fontPath'])) {
            $cmd .= " -font '{$options['fontPath']}'";
        }
        if (isset($options['hAlign'], $options['vAlign'])) {
            switch ($options['hAlign']) {
                case 'left':
                    $xAxis = $options['hOffset'] + $options['padding'];
                    $yAxis = $options['vOffset'] + $options['padding'];
                    $gravity = $options['vAlign'] === 'top' ? 'NorthWest' : 'West';
                    if ($options['vAlign'] === 'bottom') {
                        $gravity = 'SouthWest';
                        $yAxis = $options['vOffset'] - $options['padding'];
                    }
                    break;
                case 'center':
                    $xAxis = $options['hOffset'] + $options['padding'];
                    $yAxis = $options['vOffset'] + $options['padding'];
                    $gravity = $options['vAlign'] === 'top' ? 'North' : 'Center';
                    if ($options['vAlign'] === 'bottom') {
                        $yAxis = $options['vOffset'] - $options['padding'];
                        $gravity = 'South';
                    }
                    break;
                case 'right':
                    $xAxis = $options['hOffset'] - $options['padding'];
                    $yAxis = $options['vOffset'] + $options['padding'];
                    $gravity = $options['vAlign'] === 'top' ? 'NorthEast' : 'East';
                    if ($options['vAlign'] === 'bottom') {
                        $gravity = 'SouthEast';
                        $yAxis = $options['vOffset'] - $options['padding'];
                    }
                    break;
            }
            $xAxis = $xAxis >= 0 ? '+' . $xAxis : $xAxis;
            $yAxis = $yAxis >= 0 ? '+' . $yAxis : $yAxis;
            $cmd .= " -gravity {$gravity} -geometry {$xAxis}{$yAxis}";
        }
        if (isset($options['color'])) {
            [$r, $g, $b] = sscanf("#{$options['color']}", '#%02x%02x%02x');
            $cmd .= " -fill 'rgba({$r},{$g},{$b},{$options['opacity']})'";
        }
        if (isset($options['fontSize'])) {
            $cmd .= " -pointsize {$options['fontSize']}";
        }
        $cmd .= " -annotate 0 '{$text}'";
        $source = !empty($this->resource) ? $this->resource : $this->image()->getPathname();
        $destination = $this->getResourcePath();
        $cmd = " '{$source}' {$cmd} '{$destination}'";
        $this->process($cmd);
    }
}