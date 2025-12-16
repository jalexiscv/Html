<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Tag\TagInterface;
use InvalidArgumentException;

/**
 * Trait HtmlElementsTrait
 * Provee métodos de ayuda para etiquetas HTML semánticas.
 */
trait HtmlElementsTrait
{
    /**
     * Crea un elemento div.
     *
     * @param array $attributes Atributos HTML del elemento (clave => valor).
     * @param mixed $content Contenido del elemento (string, TagInterface, o array de ellos).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function div(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('div', $attributes, $content);
    }

    /**
     * Crea un elemento span.
     *
     * @param array $attributes Atributos HTML del elemento.
     * @param mixed $content Contenido del elemento.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function span(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('span', $attributes, $content);
    }

    /**
     * Crea un elemento de párrafo (p).
     *
     * @param array $attributes Atributos HTML del elemento.
     * @param mixed $content Contenido del elemento.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function p(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('p', $attributes, $content);
    }

    /**
     * Crea un elemento de enlace (a).
     *
     * @param string $href URL destino del enlace.
     * @param mixed $content Contenido del enlace (texto o elementos).
     * @param array $attributes Atributos adicionales (ej: target, rel).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function a(string $href, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['href'] = $href;
        return self::tag('a', $attributes, $content);
    }

    /**
     * Crea un elemento de imagen (img).
     *
     * @param string $src URL de la imagen.
     * @param string $alt Texto alternativo para accesibilidad.
     * @param array $attributes Atributos adicionales (ej: width, height, loading).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function img(string $src, string $alt = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['alt'] = $alt;
        return self::tag('img', $attributes);
    }

    /**
     * Crea un elemento de lista desordenada (ul).
     *
     * @param array $attributes Atributos HTML de la lista.
     * @param mixed $content Elementos de la lista (generalmente etiquetas li).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function ul(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ul', $attributes, $content);
    }

    /**
     * Crea un elemento de lista ordenada (ol).
     *
     * @param array $attributes Atributos HTML de la lista.
     * @param mixed $content Elementos de la lista.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function ol(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ol', $attributes, $content);
    }

    /**
     * Crea un elemento de ítem de lista (li).
     *
     * @param array $attributes Atributos HTML del ítem.
     * @param mixed $content Contenido del ítem.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function li(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('li', $attributes, $content);
    }

    /**
     * Crea un elemento de entrada (input).
     *
     * @param string $type Tipo de input (text, email, password, etc).
     * @param string $name Nombre del campo para el formulario.
     * @param string|null $value Valor actual del campo.
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function input(string $type, string $name, ?string $value = null, array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        if ($value !== null) {
            $attributes['value'] = $value;
        }
        return self::tag('input', $attributes);
    }

    /**
     * Crea un elemento de botón (button).
     *
     * @param mixed $content Contenido del botón (texto o iconos).
     * @param string $type Tipo de botón (button, submit, reset).
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function button(mixed $content, string $type = 'button', array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        return self::tag('button', $attributes, $content);
    }

    /**
     * Crea un elemento de script.
     *
     * @param string|null $src URL del script (opcional si es script inline).
     * @param mixed $content Contenido del script (código JS inline).
     * @param array $attributes Atributos adicionales (ej: async, defer, type).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function script(string $src = null, mixed $content = null, array $attributes = []): TagInterface
    {
        if ($src !== null) {
            $attributes['src'] = $src;
        }
        return self::tag('script', $attributes, $content);
    }

    /**
     * Crea un elemento de enlace a recurso (link).
     *
     * @param string $rel Relación del recurso (ej: stylesheet, icon).
     * @param string $href URL del recurso.
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function link(string $rel, string $href, array $attributes = []): TagInterface
    {
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;
        return self::tag('link', $attributes);
    }

    /**
     * Crea un elemento meta.
     *
     * @param array $attributes Atributos del meta tag (ej: name, content, charset).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function meta(array $attributes = []): TagInterface
    {
        return self::tag('meta', $attributes);
    }

    /**
     * Crea un componente web personalizado.
     *
     * @param string $name Nombre del componente (debe contener guión).
     * @param array $attributes Atributos del componente.
     * @param mixed $content Contenido del componente.
     * @return TagInterface La instancia del elemento creado.
     * @throws InvalidArgumentException Si el nombre no contiene un guión.
     */
    public static function webComponent(string $name, array $attributes = [], mixed $content = null): TagInterface
    {
        if (!str_contains($name, '-')) {
            throw new InvalidArgumentException('Web component names must contain a hyphen');
        }
        return self::tag($name, $attributes, $content);
    }

    // --- Metadata & Root ---

    /**
     * Crea un elemento title (título del documento).
     * @param string $content Texto del título.
     * @param array $attributes Atributos opcionales.
     */
    public static function title(string $content, array $attributes = []): TagInterface
    {
        return self::tag('title', $attributes, $content);
    }

    /**
     * Crea un elemento base.
     * @param string|null $href URL base.
     * @param string|null $target Objetivo predeterminado.
     * @param array $attributes Atributos adicionales.
     */
    public static function base(?string $href = null, ?string $target = null, array $attributes = []): TagInterface
    {
        if ($href !== null) $attributes['href'] = $href;
        if ($target !== null) $attributes['target'] = $target;
        return self::tag('base', $attributes);
    }

    // --- HTML5 Structure Tags ---

    public static function header(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('header', $attributes, $content);
    }

    public static function footer(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('footer', $attributes, $content);
    }

    public static function main(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('main', $attributes, $content);
    }

    public static function section(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('section', $attributes, $content);
    }

    public static function article(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('article', $attributes, $content);
    }

    public static function aside(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('aside', $attributes, $content);
    }

    public static function nav(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('nav', $attributes, $content);
    }

    /**
     * Crea un elemento address (información de contacto).
     */
    public static function address(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('address', $attributes, $content);
    }

    /**
     * Crea un elemento hgroup (grupo de encabezados).
     */
    public static function hgroup(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('hgroup', $attributes, $content);
    }

    // --- Headings ---

    public static function h1(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h1', $attributes, $content);
    }

    public static function h2(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h2', $attributes, $content);
    }

    public static function h3(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h3', $attributes, $content);
    }

    public static function h4(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h4', $attributes, $content);
    }

    public static function h5(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h5', $attributes, $content);
    }

    public static function h6(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('h6', $attributes, $content);
    }

    // --- Text Formatting & Utils (Inline Semantics) ---

    /**
     * Crea un elemento abbr (abreviatura).
     * @param string $title Significado completo.
     * @param mixed $content Abreviatura mostrada.
     */
    public static function abbr(string $title, mixed $content, array $attributes = []): TagInterface
    {
        $attributes['title'] = $title;
        return self::tag('abbr', $attributes, $content);
    }

    /**
     * Crea un elemento b (texto en negrita - atención).
     */
    public static function b(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('b', $attributes, $content);
    }

    /**
     * Crea un elemento bdi (aislamiento bidireccional).
     */
    public static function bdi(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('bdi', $attributes, $content);
    }

    /**
     * Crea un elemento bdo (anulación bidireccional).
     * @param string $dir Dirección del texto (lrr o rtl).
     */
    public static function bdo(string $dir, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['dir'] = $dir;
        return self::tag('bdo', $attributes, $content);
    }

    /**
     * Crea un elemento cite (cita de una obra).
     */
    public static function cite(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('cite', $attributes, $content);
    }

    /**
     * Crea un elemento data (valor legible por máquina).
     * @param string $value Valor máquina.
     * @param mixed $content Valor legible.
     */
    public static function data(string $value, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['value'] = $value;
        return self::tag('data', $attributes, $content);
    }

    /**
     * Crea un elemento del (texto eliminado).
     * @param string|null $cite URL a la explicación del cambio.
     * @param string|null $datetime Fecha del cambio.
     */
    public static function del(mixed $content = null, ?string $cite = null, ?string $datetime = null, array $attributes = []): TagInterface
    {
        if ($cite !== null) $attributes['cite'] = $cite;
        if ($datetime !== null) $attributes['datetime'] = $datetime;
        return self::tag('del', $attributes, $content);
    }

    /**
     * Crea un elemento dfn (instancia de definición).
     */
    public static function dfn(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('dfn', $attributes, $content);
    }

    /**
     * Crea un elemento i (texto en itálica - voz técnica, etc).
     */
    public static function i(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('i', $attributes, $content);
    }

    /**
     * Crea un elemento ins (texto insertado).
     */
    public static function ins(mixed $content = null, ?string $cite = null, ?string $datetime = null, array $attributes = []): TagInterface
    {
        if ($cite !== null) $attributes['cite'] = $cite;
        if ($datetime !== null) $attributes['datetime'] = $datetime;
        return self::tag('ins', $attributes, $content);
    }

    /**
     * Crea un elemento kbd (entrada de teclado).
     */
    public static function kbd(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('kbd', $attributes, $content);
    }

    /**
     * Crea un elemento mark (texto resaltado/marcado).
     */
    public static function mark(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('mark', $attributes, $content);
    }

    /**
     * Crea un elemento q (cita corta en línea).
     * @param string|null $cite URL de la fuente.
     */
    public static function q(mixed $content = null, ?string $cite = null, array $attributes = []): TagInterface
    {
        if ($cite !== null) $attributes['cite'] = $cite;
        return self::tag('q', $attributes, $content);
    }

    /**
     * Crea un elemento rp (paréntesis ruby).
     */
    public static function rp(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('rp', $attributes, $content);
    }

    /**
     * Crea un elemento rt (texto ruby).
     */
    public static function rt(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('rt', $attributes, $content);
    }

    /**
     * Crea un elemento ruby (anotación ruby).
     */
    public static function ruby(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('ruby', $attributes, $content);
    }

    /**
     * Crea un elemento s (texto tachado - ya no relevante).
     */
    public static function s(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('s', $attributes, $content);
    }

    /**
     * Crea un elemento samp (salida de programa de ejemplo).
     */
    public static function samp(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('samp', $attributes, $content);
    }

    /**
     * Crea un elemento sub (subíndice).
     */
    public static function sub(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('sub', $attributes, $content);
    }

    /**
     * Crea un elemento sup (superíndice).
     */
    public static function sup(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('sup', $attributes, $content);
    }

    /**
     * Crea un elemento time (fecha/hora).
     * @param string|null $datetime Fecha/hora máquina válida.
     */
    public static function time(mixed $content = null, ?string $datetime = null, array $attributes = []): TagInterface
    {
        if ($datetime !== null) $attributes['datetime'] = $datetime;
        return self::tag('time', $attributes, $content);
    }

    /**
     * Crea un elemento u (texto subrayado - anotación no textual).
     */
    public static function u(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('u', $attributes, $content);
    }

    /**
     * Crea un elemento var (variable).
     */
    public static function var(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('var', $attributes, $content);
    }

    /**
     * Crea un elemento wbr (oportunidad de salto de línea).
     */
    public static function wbr(array $attributes = []): TagInterface
    {
        return self::tag('wbr', $attributes);
    }

    public static function strong(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('strong', $attributes, $content);
    }

    public static function em(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('em', $attributes, $content);
    }

    public static function small(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('small', $attributes, $content);
    }

    public static function blockquote(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('blockquote', $attributes, $content);
    }

    /**
     * Crea un elemento menu (lista de comandos).
     */
    public static function menu(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('menu', $attributes, $content);
    }

    public static function pre(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('pre', $attributes, $content);
    }

    public static function code(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('code', $attributes, $content);
    }

    public static function br(array $attributes = []): TagInterface
    {
        return self::tag('br', $attributes);
    }

    public static function hr(array $attributes = []): TagInterface
    {
        return self::tag('hr', $attributes);
    }

    // --- Definition Lists ---

    public static function dl(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('dl', $attributes, $content);
    }

    public static function dt(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('dt', $attributes, $content);
    }

    public static function dd(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('dd', $attributes, $content);
    }

    // --- Interactive ---

    public static function details(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('details', $attributes, $content);
    }

    public static function summary(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('summary', $attributes, $content);
    }

    public static function dialog(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('dialog', $attributes, $content);
    }

    // --- System / Meta / Scripting ---

    /**
     * Crea un elemento noscript.
     */
    public static function noscript(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('noscript', $attributes, $content);
    }

    public static function favicon(string $href, string $type = 'image/x-icon'): TagInterface
    {
        return self::link('icon', $href, ['type' => $type]);
    }

    public static function viewport(string $content = 'width=device-width, initial-scale=1.0'): TagInterface
    {
        return self::meta(['name' => 'viewport', 'content' => $content]);
    }

    // --- Form Structure ---

    public static function fieldset(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('fieldset', $attributes, $content);
    }

    public static function legend(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('legend', $attributes, $content);
    }

    // --- Figures ---

    public static function figure(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('figure', $attributes, $content);
    }

    public static function figcaption(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('figcaption', $attributes, $content);
    }

    // --- Embedded & Graphics ---

    /**
     * Crea un elemento map (mapa de imagen).
     * @param string $name Nombre del mapa.
     */
    public static function map(string $name, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['name'] = $name;
        return self::tag('map', $attributes, $content);
    }

    /**
     * Crea un elemento area (área en mapa de imagen).
     */
    public static function area(array $attributes = []): TagInterface
    {
        return self::tag('area', $attributes);
    }

    /**
     * Crea un elemento picture (contenedor de imagen responsiva).
     */
    public static function picture(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('picture', $attributes, $content);
    }

    /**
     * Crea un elemento embed (contenido externo incrustado).
     */
    public static function embed(string $src, array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        return self::tag('embed', $attributes);
    }

    /**
     * Crea un elemento object (objeto externo).
     */
    public static function object(string $data, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['data'] = $data;
        return self::tag('object', $attributes, $content);
    }

    /**
     * Crea un elemento portal (contenido incrustado para navegación - experimental).
     */
    public static function portal(string $src, array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        return self::tag('portal', $attributes);
    }

    /**
     * Crea un elemento template (plantilla de contenido).
     */
    public static function template(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('template', $attributes, $content);
    }

    /**
     * Crea un elemento slot (placeholder para Web Components).
     * @param string $name Nombre del slot.
     */
    public static function slot(string $name, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['name'] = $name;
        return self::tag('slot', $attributes, $content);
    }

    public static function iframe(string $src, array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        return self::tag('iframe', $attributes);
    }

    public static function canvas(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('canvas', $attributes, $content);
    }

    public static function progress(mixed $value = null, mixed $max = null, array $attributes = [], mixed $content = null): TagInterface
    {
        if ($value !== null) $attributes['value'] = $value;
        if ($max !== null) $attributes['max'] = $max;
        return self::tag('progress', $attributes, $content);
    }

    public static function meter(mixed $value = null, array $attributes = [], mixed $content = null): TagInterface
    {
        if ($value !== null) $attributes['value'] = $value;
        return self::tag('meter', $attributes, $content);
    }

    // --- Style ---

    public static function style(mixed $content = null, array $attributes = []): TagInterface
    {
        return self::tag('style', $attributes, $content);
    }
}
