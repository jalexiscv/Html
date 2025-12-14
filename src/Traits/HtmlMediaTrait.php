<?php

declare(strict_types=1);

namespace Higgs\Html\Traits;

use Higgs\Html\Tag\TagInterface;

/**
 * Trait HtmlMediaTrait
 * Provee métodos para elementos multimedia (HTML5 Audio/Video).
 */
trait HtmlMediaTrait
{
    /**
     * Crea un elemento de audio.
     *
     * @param string|array|null $src URL del archivo o array de sources.
     * @param array $attributes Atributos (controls, autoplay, loop, muted).
     */
    public static function audio(string|array|null $src = null, array $attributes = []): TagInterface
    {
        $tag = self::tag('audio', $attributes);
        
        if (is_string($src)) {
            $tag->attr('src', $src);
        } elseif (is_array($src)) {
            foreach ($src as $s) {
                $tag->addChild(self::source($s));
            }
        }

        return $tag;
    }

    /**
     * Crea un elemento de video.
     *
     * @param string|array|null $src URL del archivo o array de sources.
     * @param string|null $poster URL de la imagen poster.
     * @param array $attributes Atributos (controls, width, height).
     */
    public static function video(string|array|null $src = null, ?string $poster = null, array $attributes = []): TagInterface
    {
        if ($poster !== null) {
            $attributes['poster'] = $poster;
        }

        $tag = self::tag('video', $attributes);

        if (is_string($src)) {
            $tag->attr('src', $src);
        } elseif (is_array($src)) {
            foreach ($src as $s) {
                $tag->addChild(self::source($s));
            }
        }

        return $tag;
    }

    /**
     * Crea un elemento source.
     *
     * @param string|array $src URL o array con ['src' => '...', 'type' => '...'].
     */
    public static function source(string|array $src, ?string $type = null): TagInterface
    {
        $attributes = [];
        if (is_array($src)) {
            $attributes = $src;
        } else {
            $attributes['src'] = $src;
            if ($type) {
                $attributes['type'] = $type;
            }
        }
        
        return self::tag('source', $attributes);
    }

    /**
     * Crea un elemento track (subtítulos).
     */
    public static function track(string $src, string $kind = 'subtitles', string $srclang = 'en', string $label = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['kind'] = $kind;
        $attributes['srclang'] = $srclang;
        if ($label) {
            $attributes['label'] = $label;
        }
        
        return self::tag('track', $attributes);
    }
}
