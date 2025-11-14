<?php

/**
 * HtmlExtractor.php
 * Extractor de información HTML usando DOMDocument y DOMXPath (sin librerías externas).
 *
 * Responsabilidades:
 * - extract: obtiene título, meta description, headings, párrafos, imágenes y enlaces absolutos.
 * - cleanView: genera HTML limpio del contenido principal básico (heurística simple por densidad de texto).
 * - extractPublishedDate: intenta detectar fecha YYYY-MM-DD en el HTML crudo por patrones comunes.
 * - extractTagsFromHtml: produce n-gramas simples como tags a partir de contenido limpio (heurística).
 */
class HtmlExtractor
{
    /**
     * Extrae información general de una página HTML.
     * @param string $html HTML fuente
     * @param string $baseUrl URL base para resolver enlaces relativos
     * @return array{title:string,meta_description:string,headings:array,paragraphs:array,images:array,links:array}
     */
    public function extract($html, $baseUrl)
    {
        $dom = $this->createDom($html);
        $xp = new DOMXPath($dom);

        $title = '';
        $tNodes = $dom->getElementsByTagName('title');
        if ($tNodes->length > 0) {
            $title = trim($tNodes->item(0)->textContent);
        }

        $metaDesc = '';
        foreach ($dom->getElementsByTagName('meta') as $m) {
            $name = strtolower($m->getAttribute('name'));
            if ($name === 'description') {
                $metaDesc = trim($m->getAttribute('content'));
                break;
            }
        }

        $headings = [];
        foreach (['h1', 'h2', 'h3'] as $h) {
            foreach ($dom->getElementsByTagName($h) as $hn) {
                $txt = trim($hn->textContent);
                if ($txt !== '') $headings[] = $txt;
            }
        }

        $paragraphs = [];
        foreach ($dom->getElementsByTagName('p') as $p) {
            $txt = trim($p->textContent);
            if ($txt !== '' && mb_strlen($txt, 'UTF-8') >= 60) {
                $paragraphs[] = $txt;
            }
        }

        $images = [];
        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = trim($img->getAttribute('src'));
            if ($src !== '') {
                $images[] = $this->absUrl($src, $baseUrl);
            }
        }

        $links = [];
        foreach ($dom->getElementsByTagName('a') as $a) {
            $href = trim($a->getAttribute('href'));
            if ($href === '' || stripos($href, 'javascript:') === 0) continue;
            $abs = $this->absUrl($href, $baseUrl);
            if ($abs !== '' && filter_var($abs, FILTER_VALIDATE_URL)) {
                $links[] = $abs;
            }
        }
        // Unicos y normalizados
        $links = array_values(array_unique($links));

        return [
            'title' => $title,
            'meta_description' => $metaDesc,
            'headings' => $headings,
            'paragraphs' => $paragraphs,
            'images' => $images,
            'links' => $links,
        ];
    }

    /** @return DOMDocument */
    private function createDom($html)
    {
        $dom = new DOMDocument();
        $prev = libxml_use_internal_errors(true);
        $html = $this->ensureUtf8($html);
        $dom->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($prev);
        return $dom;
    }

    private function ensureUtf8($html)
    {
        // Si ya es UTF-8 válido, devolver tal cual
        if (mb_detect_encoding($html, 'UTF-8', true)) return $html;
        $enc = mb_detect_encoding($html, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($enc && strtoupper($enc) !== 'UTF-8') {
            $html = mb_convert_encoding($html, 'UTF-8', $enc);
        }
        return $html;
    }

    private function absUrl($url, $base)
    {
        if (!is_string($url) || $url === '') return '';
        // ya absoluta
        if (preg_match('#^[a-z][a-z0-9+.-]*://#i', $url)) return $url;
        if (!$base || !filter_var($base, FILTER_VALIDATE_URL)) return '';
        $p = parse_url($base);
        if (!$p || empty($p['scheme']) || empty($p['host'])) return '';
        $scheme = $p['scheme'];
        $host = $p['host'];
        $port = isset($p['port']) ? (':' . $p['port']) : '';
        $basePath = isset($p['path']) ? $p['path'] : '/';
        // Si url inicia con '/': relativo a raíz
        if (strpos($url, '/') === 0) {
            $path = $url;
        } else {
            // relativo al directorio del basePath
            $dir = rtrim(substr($basePath, 0, strrpos($basePath, '/') !== false ? strrpos($basePath, '/') : 0), '/');
            $path = $dir . '/' . $url;
        }
        // normalizar .. y .
        $path = preg_replace('#/\./#', '/', $path);
        while (strpos($path, '/../') !== false) {
            $path = preg_replace('#/[^/]+/\.\./#', '/', $path, 1);
        }
        // Normalizar múltiples barras
        $path = preg_replace('#/{2,}#', '/', $path);
        return $scheme . '://' . $host . $port . ($path[0] === '/' ? '' : '/') . $path;
    }

    // ------------------------ Utilidades internas -------------------------

    /**
     * Genera una vista limpia del contenido principal.
     * Si se provee un $preset con XPaths, se usan directamente; de lo contrario, se aplica la heurística por densidad de texto.
     *
     * @param string $html HTML crudo descargado
     * @param string $baseUrl URL final (para absolutizar enlaces)
     * @param array|null $preset Reglas opcionales por dominio:
     *   - content_xpath: XPath del contenedor principal del artículo
     *   - title_xpath:   XPath del título del artículo (opcional)
     *   - remove_xpaths: array de XPaths a eliminar del contenedor (ads, nav, share, etc.)
     *   - absolutize_attrs: array de atributos a absolutizar (por defecto ['href','src'])
     *   - featured_xpath: XPath de <img> (o atributo @src) para imagen destacada (opcional)
     * @return array{title:string,content_html:string,featured:?string}
     */
    public function cleanView($html, $baseUrl, $preset = null)
    {
        $dom = $this->createDom($html);
        $title = '';
        $tNodes = $dom->getElementsByTagName('title');
        if ($tNodes->length > 0) $title = trim($tNodes->item(0)->textContent);

        $xp = new DOMXPath($dom);
        $featured = null;
        $bestHtml = '';

        // Si hay preset con XPaths, aplicarlo
        if (is_array($preset) && !empty($preset)) {
            $attrs = isset($preset['absolutize_attrs']) && is_array($preset['absolutize_attrs']) ? $preset['absolutize_attrs'] : ['href', 'src'];

            // Título por XPath (opcional)
            if (!empty($preset['title_xpath'])) {
                $tn = @$xp->query($preset['title_xpath']);
                if ($tn && $tn->length > 0) {
                    $title = trim($tn->item(0)->textContent);
                }
            }

            // Contenido principal por XPath (requerido para usar preset)
            if (!empty($preset['content_xpath'])) {
                $nodes = @$xp->query($preset['content_xpath']);
                if ($nodes && $nodes->length > 0) {
                    /** @var DOMElement $best */
                    $best = $nodes->item(0);
                    // Remociones específicas por XPath
                    if (!empty($preset['remove_xpaths']) && is_array($preset['remove_xpaths'])) {
                        foreach ($preset['remove_xpaths'] as $rx) {
                            $this->removeByXPath($best, $rx);
                        }
                    }
                    // Limpiezas genéricas por tag
                    $this->removeByTags($best, ['script', 'style', 'noscript', 'nav', 'footer', 'aside', 'form']);
                    // Absolutizar atributos
                    $this->absolutizeAttributes($best, $baseUrl, $attrs);
                    $bestHtml = $this->innerHTML($best);
                }
            }

            // Imagen destacada (opcional)
            if (!empty($preset['featured_xpath'])) {
                $fn = @$xp->query($preset['featured_xpath']);
                if ($fn && $fn->length > 0) {
                    $node = $fn->item(0);
                    $src = '';
                    if ($node instanceof DOMElement) {
                        // Si es elemento <img>
                        if (strtolower($node->tagName) === 'img' && $node->hasAttribute('src')) {
                            $src = $node->getAttribute('src');
                        } elseif ($node->hasAttribute('content')) { // meta o similar
                            $src = $node->getAttribute('content');
                        }
                    } elseif ($node instanceof DOMAttr) {
                        $src = (string)$node->value;
                    } else {
                        $src = trim($node->textContent);
                    }
                    if ($src !== '') {
                        $abs = $this->absUrl($src, $baseUrl);
                        if ($abs !== '' && filter_var($abs, FILTER_VALIDATE_URL)) {
                            $featured = $abs;
                        }
                    }
                }
            }
        }

        // Si no hubo preset o no se obtuvo contenido, aplicar heurística por densidad
        if ($bestHtml === '') {
            $candidates = [];
            $body = $dom->getElementsByTagName('body')->item(0);
            if ($body) {
                $this->collectBlocks($body, $candidates);
            }
            usort($candidates, function ($a, $b) {
                return $b['len'] <=> $a['len'];
            });
            if (!empty($candidates)) {
                $best = $candidates[0]['node'];
                $this->removeByTags($best, ['script', 'style', 'noscript', 'nav', 'footer', 'aside', 'form']);
                $this->absolutizeAttributes($best, $baseUrl, ['href', 'src']);
                $bestHtml = $this->innerHTML($best);
            }
        }

        // Después de obtener el mejor HTML, extraer las imágenes de ese bloque
        $contentImages = [];
        if ($bestHtml !== '') {
            $tempDom = $this->createDom('<div>' . $bestHtml . '</div>');
            $imgTags = $tempDom->getElementsByTagName('img');
            foreach ($imgTags as $img) {
                $src = $img->getAttribute('src');
                if ($src && filter_var($src, FILTER_VALIDATE_URL)) {
                    $contentImages[] = $src;
                }
            }
        }

        return [
            'title' => $title,
            'content_html' => $bestHtml,
            'featured' => $featured,
            'images' => $contentImages, // Devolver las imágenes encontradas
        ];
    }

    /**
     * Elimina nodos que coincidan con un XPath relativo al subárbol $root.
     * @param DOMElement $root
     * @param string $xpath
     */
    private function removeByXPath(DOMElement $root, $xpath)
    {
        if (!is_string($xpath) || trim($xpath) === '') return;
        $xp = new DOMXPath($root->ownerDocument);
        $res = @$xp->query($xpath, $root);
        if ($res && $res->length > 0) {
            for ($i = $res->length - 1; $i >= 0; $i--) {
                $n = $res->item($i);
                if ($n && $n->parentNode) {
                    $n->parentNode->removeChild($n);
                }
            }
        }
    }

    private function removeByTags(DOMElement $root, array $tags)
    {
        foreach ($tags as $t) {
            $list = $root->getElementsByTagName($t);
            // recorrer hacia atrás porque live nodeList
            for ($i = $list->length - 1; $i >= 0; $i--) {
                $n = $list->item($i);
                if ($n && $n->parentNode) {
                    $n->parentNode->removeChild($n);
                }
            }
        }
    }

    private function absolutizeAttributes(DOMElement $root, $baseUrl, array $attrs)
    {
        $it = $root->getElementsByTagName('*');
        foreach ($it as $el) {
            foreach ($attrs as $a) {
                if ($el->hasAttribute($a)) {
                    $el->setAttribute($a, $this->absUrl($el->getAttribute($a), $baseUrl));
                }
            }
        }
    }

    private function innerHTML(DOMNode $node)
    {
        $doc = $node->ownerDocument;
        $html = '';
        foreach ($node->childNodes as $child) {
            $html .= $doc->saveHTML($child);
        }
        return $html;
    }

    private function collectBlocks(DOMNode $node, array &$out)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                /** @var DOMElement $child */
                $tag = strtolower($child->nodeName);
                // considerar elementos de tipo bloque comunes
                if (in_array($tag, ['article', 'section', 'main', 'div', 'ul', 'ol'], true)) {
                    $txt = trim($child->textContent);
                    $len = mb_strlen($txt, 'UTF-8');
                    if ($len > 0) {
                        $out[] = ['node' => $child, 'len' => $len];
                    }
                }
                $this->collectBlocks($child, $out);
            }
        }
    }

    /**
     * Intenta detectar fecha en formato YYYY-MM-DD en el HTML crudo.
     * Busca patrones comunes (meta property, time datetime, texto).
     * @param string $html
     * @return string YYYY-MM-DD o cadena vacía si no se detecta
     */
    public function extractPublishedDate($html)
    {
        // time datetime="2024-05-21"
        if (preg_match('/<time[^>]+datetime\s*=\s*"(\d{4}-\d{2}-\d{2})"/i', $html, $m)) {
            return $m[1];
        }
        // meta property or name
        if (preg_match('/<meta[^>]+(property|name)\s*=\s*"(?:article:published_time|pubdate|date|dc.date)"[^>]+content\s*=\s*"(\d{4}-\d{2}-\d{2})/i', $html, $m)) {
            return $m[2];
        }
        // Texto suelto YYYY-MM-DD
        if (preg_match('/(20\d{2}-\d{2}-\d{2})/', $html, $m)) {
            return $m[1];
        }
        return '';
    }

    /**
     * Genera tags heurísticos a partir de contenido limpio (palabras frecuentes relevantes).
     * @param string $contentHtml
     * @param int $max Máximo de etiquetas a retornar
     * @return array<string>
     */
    public function extractTagsFromHtml($contentHtml, $max = 12)
    {
        $text = strip_tags($contentHtml);
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $stop = $this->stopwordsEs();
        $freq = [];
        foreach ($words as $w) {
            if (mb_strlen($w, 'UTF-8') < 4) continue;
            if (isset($stop[$w])) continue;
            $freq[$w] = ($freq[$w] ?? 0) + 1;
        }
        arsort($freq);
        return array_slice(array_keys($freq), 0, max(1, (int)$max));
    }

    private function stopwordsEs()
    {
        // Conjunto mínimo de stopwords en español para filtrar
        $list = [
            'sobre', 'entre', 'para', 'como', 'cuando', 'donde', 'desde', 'hasta', 'pero', 'porque', 'puede', 'cada', 'haber', 'este', 'esta', 'esto', 'estas', 'estos', 'esas', 'esos', 'aqui', 'alli', 'solo', 'muy', 'tambien', 'aunque', 'segun', 'tras', 'otros', 'otras', 'cual', 'cuales', 'quien', 'quienes', 'cuyo', 'cuya', 'cuyos', 'cuyas', 'ante', 'bajo', 'cabe', 'con', 'contra', 'de', 'del', 'la', 'las', 'lo', 'los', 'el', 'un', 'una', 'unos', 'unas', 'al', 'y', 'o', 'u', 'e', 'ni', 'no', 'si', 'ya', 'le', 'les', 'su', 'sus', 'se', 'me', 'te', 'mi', 'mis', 'tu', 'tus', 'nuestro', 'nuestra', 'nuestros', 'nuestras', 'vosotros', 'vosotras', 'vuestro', 'vuestra', 'vuestros', 'vuestras', 'ellos', 'ellas', 'nosotros', 'nosotras', 'que', 'a', 'en', 'por', 'es', 'son', 'fue', 'ha', 'han', 'ser', 'hay'
        ];
        $out = [];
        foreach ($list as $w) {
            $out[$w] = true;
        }
        return $out;
    }

    /**
     * Extrae todas las imágenes que se consideran "responsive".
     * Busca <img> que contengan la clase 'responsive'.
     *
     * @param string $html HTML completo de la página.
     * @param string $baseUrl URL base para resolver rutas relativas de imágenes.
     * @return array Lista de URLs absolutas de las imágenes responsive.
     */
    public function extractResponsiveImages($html, $baseUrl)
    {
        if (empty($html) || empty($baseUrl)) {
            return [];
        }

        $doc = $this->createDom($html);
        $xpath = new DOMXPath($doc);

        // Buscar imágenes que contengan la palabra "responsive" en su atributo class
        // Se usa concat y normalize-space para manejar clases múltiples de forma segura
        $images = $xpath->query('//img[contains(concat(" ", normalize-space(@class), " "), " responsive ")]');
        $imageUrls = [];

        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            if ($src) {
                $absoluteUrl = $this->absUrl($src, $baseUrl);
                $imageUrls[] = $absoluteUrl;
            }
        }

        return $imageUrls;
    }
}
