# Referencia de Helpers Semánticos

Esta guía lista todos los métodos estáticos disponibles en la clase `Html` (vía `HtmlElementsTrait`, `HtmlTableTrait`, `HtmlFormTrait`, etc.) para generar etiquetas HTML5 semánticas.


## Manipulación de Atributos e Interfaz Fluida

Todos los objetos retornados por la librería implementan una **interfaz fluida** (method chaining). Esto significa que puedes encadenar métodos para modificar la etiqueta después de crearla.

Esto es especialmente útil para agregar atributos como `class`, `id`, `style` de forma limpia.

```php
// Método 1: Pasando atributos en el constructor (array)
echo Html::a('#', 'Click aquí', ['class' => 'btn btn-primary']);

// Método 2: Usando la interfaz fluida
echo Html::a('#', 'Click aquí')
    ->attr('class', 'text-danger bold')
    ->attr('id', 'mi-enlace')
    ->attr('data-toggle', 'modal');
```

También puedes usar método mágicos para atributos comunes (aunque `attr()` es el estándar más robusto):
```php
echo Html::div("Contenido")
    ->id("main-container")
    ->class("p-4 bg-light"); 
```

---

## Estructura del Documento y Metadatos

Helpers para el `head` y la configuración del documento.

| Helper | Etiqueta | Ejemplo | Descripción |
| :--- | :--- | :--- | :--- |
| `Html::title($text)` | `<title>` | `Html::title("Mi Página")` | Título del documento. |
| `Html::base($href, $target)` | `<base>` | `Html::base("/app/", "_blank")` | URL base para enlaces. |
| `Html::meta($attrs)` | `<meta>` | `Html::meta(['charset' => 'utf-8'])` | Metadatos genéricos. |
| `Html::viewport($content)` | `<meta>` | `Html::viewport()` | Configura viewport móvil standard. |
| `Html::favicon($href)` | `<link>` | `Html::favicon("/icon.png")` | Enlace al favicon. |
| `Html::link($rel, $href)` | `<link>` | `Html::link("stylesheet", "style.css")` | Enlace a recurso externo. |
| `Html::style($css)` | `<style>` | `Html::style("body { color: red; }")` | CSS en línea. |

## Seccionamiento (Layout)

Etiquetas para definir la estructura principal de la página.

| Helper | Etiqueta | Ejemplo |
| :--- | :--- | :--- |
| `Html::header($content)` | `<header>` | `Html::header("Logo")` |
| `Html::nav($content)` | `<nav>` | `Html::nav("Links...")` |
| `Html::main($content)` | `<main>` | `Html::main("Contenido Principal")` |
| `Html::section($content)` | `<section>` | `Html::section(Html::h2("Título")...)` |
| `Html::article($content)` | `<article>` | `Html::article("Post...")` |
| `Html::aside($content)` | `<aside>` | `Html::aside("Publicidad...")` |
| `Html::footer($content)` | `<footer>` | `Html::footer("Copyright")` |
| `Html::address($content)` | `<address>` | `Html::address("Contacto...")` |
| `Html::hgroup($content)` | `<hgroup>` | `Html::hgroup(Html::h1("A").Html::h2("B"))` |

## Contenido de Texto

Elementos de bloque para estructurar texto.

| Helper | Etiqueta | Ejemplo |
| :--- | :--- | :--- |
| `Html::h1($text)`...`h6` | `<h1>`-`<h6>` | `Html::h1("Título Principal")` |
| `Html::p($text)` | `<p>` | `Html::p("Un párrafo.")` |
| `Html::div($content)` | `<div>` | `Html::div("Contenedor genérico")` |
| `Html::blockquote($text)` | `<blockquote>` | `Html::blockquote("Una cita")` |
| `Html::pre($text)` | `<pre>` | `Html::pre("código crudo")` |
| `Html::hr()` | `<hr>` | `Html::hr()` (Línea horizontal) |
| `Html::ul($items)` | `<ul>` | `Html::ul(Html::li("Item"))` |
| `Html::ol($items)` | `<ol>` | `Html::ol(Html::li("Item"))` |
| `Html::li($content)` | `<li>` | `Html::li("Elemento de lista")` |
| `Html::dl($content)` | `<dl>` | `Html::dl(...)` (Lista de definición) |
| `Html::dt($text)` | `<dt>` | `Html::dt("Término")` |
| `Html::dd($text)` | `<dd>` | `Html::dd("Definición")` |
| `Html::figure($content)` | `<figure>` | `Html::figure(Html::img(...))` |
| `Html::figcaption($text)` | `<figcaption>` | `Html::figcaption("Leyenda")` |

## Semántica en Línea (Inline)

Elementos para dar significado a partes del texto.

```php
// Ejemplo de uso
echo Html::p(
    "Hola " . Html::strong("Mundo") . ", aprende " . Html::abbr("HTML", "HyperText Markup Language")
);
```

| Helper | Etiqueta | Descripción |
| :--- | :--- | :--- |
| `Html::a($href, $text)` | `<a>` | Hipervínculo. |
| `Html::strong($text)` | `<strong>` | Importancia fuerte (negrita). |
| `Html::em($text)` | `<em>` | Énfasis (itálica). |
| `Html::small($text)` | `<small>` | Letra pequeña / legal. |
| `Html::s($text)` | `<s>` | Texto tachado (no relevante). |
| `Html::cite($text)` | `<cite>` | Cita de una obra. |
| `Html::q($text)` | `<q>` | Cita corta en línea. |
| `Html::dfn($text)` | `<dfn>` | Definición de término. |
| `Html::abbr($title, $txt)`| `<abbr>` | Abreviatura. |
| `Html::data($val, $txt)` | `<data>` | Valor legible por máquina. |
| `Html::time($date)` | `<time>` | Fecha/Hora semántica. |
| `Html::code($text)` | `<code>` | Fragmento de código. |
| `Html::var($text)` | `<var>` | Variable matemática/código. |
| `Html::samp($text)` | `<samp>` | Salida de programa. |
| `Html::kbd($text)` | `<kbd>` | Entrada de teclado. |
| `Html::sub($text)` | `<sub>` | Subíndice. |
| `Html::sup($text)` | `<sup>` | Superíndice. |
| `Html::i($text)` | `<i>` | Voz alternativa / técnico. |
| `Html::b($text)` | `<b>` | Atención (keywords). |
| `Html::u($text)` | `<u>` | Anotación no textual (subrayado). |
| `Html::mark($text)` | `<mark>` | Texto resaltado. |
| `Html::ruby($content)` | `<ruby>` | Anotaciones Ruby (asiáticas). |
| `Html::rt($text)` | `<rt>` | Texto Ruby. |
| `Html::rp($text)` | `<rp>` | Paréntesis Ruby. |
| `Html::bdi($text)` | `<bdi>` | Aislamiento bidireccional. |
| `Html::bdo($dir, $text)` | `<bdo>` | Override bidireccional. |
| `Html::span($content)` | `<span>` | Contenedor en línea genérico. |
| `Html::br()` | `<br>` | Salto de línea. |
| `Html::wbr()` | `<wbr>` | Oportunidad de salto. |
| `Html::del($text)` | `<del>` | Texto eliminado. |
| `Html::ins($text)` | `<ins>` | Texto insertado. |

## Multimedia e Incrustados

| Helper | Etiqueta | Uso |
| :--- | :--- | :--- |
| `Html::img($src, $alt)` | `<img>` | Imagen. |
| `Html::picture($content)`| `<picture>` | Contenedor de imagen responsiva. |
| `Html::source($src)` | `<source>` | Recurso para picture/audio/video. |
| `Html::audio($src)` | `<audio>` | Reproductor de audio. |
| `Html::video($src)` | `<video>` | Reproductor de video. |
| `Html::track($src)` | `<track>` | Subtítulos/CC. |
| `Html::iframe($src)` | `<iframe>` | Marco incrustado. |
| `Html::embed($src)` | `<embed>` | Incrustación genérica. |
| `Html::object($data)` | `<object>` | Objeto externo. |
| `Html::param($name, $val)`| `<param>` | Parámetro de object. (Usar `tag('param')`) |
| `Html::map($name)` | `<map>` | Mapa de imagen. |
| `Html::area()` | `<area>` | Área clickable en mapa. |
| `Html::canvas()` | `<canvas>` | Lienzo de dibujo. |
| `Html::progress($val)` | `<progress>` | Barra de progreso. |
| `Html::meter($val)` | `<meter>` | Medidor escalar. |
| `Html::portal($src)` | `<portal>` | *Experimental*. |

## Formularios (Forms)

Además del método genérico `form()`, existen helpers para cada control.

| Helper | Descripción |
| :--- | :--- |
| `Html::form($attrs)` | Contenedor del formulario. |
| `Html::label($for, $text)` | Etiqueta de control. |
| `Html::input($type, $name)` | Input genérico. |
| `Html::text($name)` | Input text. |
| `Html::email($name)` | Input email. |
| `Html::password($name)` | Input password. |
| `Html::file($name)` | Input file. |
| `Html::checkbox($name)` | Input checkbox. |
| `Html::radio($name)` | Input radio. |
| `Html::textarea($name)` | Área de texto multilínea. |
| `Html::select($name, $opts)`| Menú desplegable. |
| `Html::optgroup($label)` | Grupo de opciones. |
| `Html::option($txt, $val)` | Opción individual. |
| `Html::datalist($id)` | Lista de autocompletado. |
| `Html::button($txt)` | Botón (submit/button). |
| `Html::output($for)` | Resultado de cálculo. |
| `Html::fieldset($content)` | Grupo de campos. |
| `Html::legend($text)` | Título del fieldset. |

**Nota sobre `time`**: Usa `Html::inputTime()` para inputs `<input type="time">` y `Html::time()` para la etiqueta semántica `<time>`.

## Tablas (Tables)

Puedes usar el constructor rápido `Html::table()` o construirla elemento por elemento.

```php
// Construcción atómica
Html::table()
    ->addChild(Html::caption("Título"))
    ->addChild(Html::thead(
        Html::tr(Html::th("Columna A"))
    ))
    ->addChild(Html::tbody(
        Html::tr(Html::td("Dato A"))
    ));
```

| Helper | Etiqueta |
| :--- | :--- |
| `Html::table()` | `<table>` |
| `Html::caption()` | `<caption>` |
| `Html::colgroup()` | `<colgroup>` |
| `Html::col()` | `<col>` |
| `Html::thead()` | `<thead>` |
| `Html::tbody()` | `<tbody>` |
| `Html::tfoot()` | `<tfoot>` |
| `Html::tr()` | `<tr>` |
| `Html::th()` | `<th>` |
| `Html::td()` | `<td>` |

## Scripting y Web Components

| Helper | Etiqueta | Descripción |
| :--- | :--- | :--- |
| `Html::script($src)` | `<script>` | JavaScript. |
| `Html::noscript($content)` | `<noscript>` | Contenido alternativo sin JS. |
| `Html::template($content)` | `<template>` | Contenido inerte para clonar. |
| `Html::slot($name)` | `<slot>` | Placeholder de Shadow DOM. |
| `Html::webComponent($tag)` | `<x-tag>` | Custom Element (require guión). |

## Interactividad

| Helper | Etiqueta | Descripción |
| :--- | :--- | :--- |
| `Html::details($content)` | `<details>` | Widget de acordeón nativo. |
| `Html::summary($text)` | `<summary>` | Título visible de details. |
| `Html::dialog($content)` | `<dialog>` | Ventana modal nativa. |
