<?php

namespace App\Libraries;

/**
 * BBCode proveniente del inglés Bulletin Board Code es un lenguaje de marcas
 * ligero utilizado preferentemente en foros de discusión y correos electrónicos
 * para embellecer la forma en que un mensaje o post es presentado. Los BBCodes
 * no pueden ser interpretados directamente por un navegador web, por lo que
 * es el propio sistema del foro el que se encarga de traducir el contenido
 * marcado en BBCode hacia un lenguaje que los navegadores web puedan entender,
 * ya sea HTML o XHTML. BBCode no se encuentra oficialmente regulado, pero
 * debido a su amplia utilización se ha convertido en un estándar de facto,
 * así como en un estándar de mejor práctica actual. Esta clase permite gestionar
 * todo lo relacionado con la manipulación del BBCode en la plataforma desde
 * las conversiones de BBCode a HTML y viceversa.
 * @access public
 * @param string unparsed string
 * @param int max image width
 * @return string
 */
class BBCode
{
    private static $url;
    /**
     * Static case insensitive flag to enable
     * case insensitivity when parsing BBCode.
     */
    private static $CASE_INSENSITIVE = 0;

    public function __construct($url = "")
    {
        self::$url = $url;
    }

    private static function stripTags(string $source)
    {
        foreach (self::parsers as $name => $parser) {
            $source = self::searchAndReplace($parser['pattern'] . 'i', $parser['content'], $source);
        }
        return ($source);
    }

    public function searchAndReplace(string $pattern, string $replace, string $source)
    {
        while (preg_match($pattern, $source)) {
            if ($pattern == '/\[video\](.*?)\[\/video\]/s') {
                $source = preg_replace_callback($pattern, array($this, 'get_VideoCallback'), $source);
            } elseif ($pattern == '/\[img\](.*?)\[\/img\]/s') {
                $source = preg_replace_callback($pattern, array($this, 'get_ImageCallback'), $source);
            } elseif ($pattern == '/\[code\](.*?)\[\/code\]/s') {
                $source = preg_replace_callback($pattern, array($this, 'get_CodeCallback'), $source);
            } elseif ($pattern == '/\[markdown\](.*?)\[\/markdown\]/s') {
                $source = preg_replace_callback($pattern, array($this, 'get_MarkdownCallback'), $source);
            } else {
                $source = preg_replace($pattern, $replace, $source);
            }
        }
        return ($source);
    }

//        public  function only($only = null) {
//            $only = is_array($only) ? $only : func_get_args();
//            self::parsers = array_intersect_key(self::parsers, array_flip((array) $only));
//            return $this;
//        }
//        public  function except($except = null) {
//            $except = is_array($except) ? $except : func_get_args();
//            self::parsers = array_diff_key(self::parsers, array_flip((array) $except));
//            return $this;
//        }
//        public  function addParser(string $name, string $pattern, string $replace, string $content) {
//            self::parsers = array_merge(self::parsers,[
//                $name => [
//                    'pattern' => $pattern,
//                    'replace' => $replace,
//                    'content' => $content,
//                ],
//            ]);
//        }

    public function getHTML($str = "")
    {
        return ($this->parse($str));
    }

    private function parse(string $source, $caseInsensitive = null)
    {
        $caseInsensitive = $caseInsensitive === self::$CASE_INSENSITIVE ? true : false;
        $parsers = self::parsers();
        foreach ($parsers as $name => $parser) {
            $pattern = ($caseInsensitive) ? $parser['pattern'] . 'i' : $parser['pattern'];
            $source = $this->searchAndReplace($pattern, $parser['replace'], $source);
        }
        return ($source);
    }

    private static function parsers()
    {
        return ([
            'p' => [
                'pattern' => '/\[p\](.*?)\[\/p\]/s',
                'replace' => '<p>$1</p>',
                'content' => '$1'
            ],
            'h1' => [
                'pattern' => '/\[h1\](.*?)\[\/h1\]/s',
                'replace' => '<h1>$1</h1>',
                'content' => '$1'
            ],
            'h2' => [
                'pattern' => '/\[h2\](.*?)\[\/h2\]/s',
                'replace' => '<h2 class="subtitle">$1</h2>',
                'content' => '$1'
            ],
            'h3' => [
                'pattern' => '/\[h3\](.*?)\[\/h3\]/s',
                'replace' => '<h3 class=\"headline\">$1</h3>',
                'content' => '$1'
            ],
            'h4' => [
                'pattern' => '/\[h4\](.*?)\[\/h4\]/s',
                'replace' => '<h4>$1</h4>',
                'content' => '$1'
            ],
            'h5' => [
                'pattern' => '/\[h5\](.*?)\[\/h5\]/s',
                'replace' => '<h5>$1</h5>',
                'content' => '$1'
            ],
            'h6' => [
                'pattern' => '/\[h6\](.*?)\[\/h6\]/s',
                'replace' => '<h6>$1</h6>',
                'content' => '$1'
            ],
            'bold' => [
                'pattern' => '/\[b\](.*?)\[\/b\]/s',
                'replace' => '<b>$1</b>',
                'content' => '$1'
            ],
            'italic' => [
                'pattern' => '/\[i\](.*?)\[\/i\]/s',
                'replace' => '<i>$1</i>',
                'content' => '$1'
            ],
            'underline' => [
                'pattern' => '/\[u\](.*?)\[\/u\]/s',
                'replace' => '<u>$1</u>',
                'content' => '$1'
            ],
            'strikethrough' => [
                'pattern' => '/\[s\](.*?)\[\/s\]/s',
                'replace' => '<s>$1</s>',
                'content' => '$1'
            ],
            'quote' => [
                'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
                'replace' => '<blockquote>$1</blockquote>',
                'content' => '$1'
            ],
            'blockquote' => [
                'pattern' => '/\[blockquote\](.*?)\[\/blockquote\]/s',
                'replace' => '<blockquote>«$1»</blockquote>',
                'content' => '$1'
            ],
            'link-anchor' => [
                'pattern' => '/\[a\](.*?)\[\/a\]/s',
                'replace' => '<sup><a name=\"#$1\"></a></sup>',
                'content' => '$1'
            ],
            'cite' => [
                'pattern' => '/\[cite\](.*?)\[\/cite\]/s',
                'replace' => '<cite>$1</cite>',
                'content' => '$1'
            ],
            'url' => [
                'pattern' => '/\[url\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$1</a>',
                'content' => '$1'
            ],
            'named-url' => [
                'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$2</a>',
                'content' => '$1$2'
            ],
            'link' => [
                'pattern' => '/\[link\](.*?)\[\/link\]/s',
                'replace' => '<a href="$1" target="_blank">$1</a>',
                'content' => '$1'
            ],
            'named-link' => [
                'pattern' => '/\[link\=(.*?)\](.*?)\[\/link\]/s',
                'replace' => '<a href="$1" target="_blank">$2</a>',
                'content' => '$1$2'
            ],
            'source-link' => [
                'pattern' => '/\[source\=(.*?)\](.*?)\[\/source\]/s',
                'replace' => '<p><b>Fuente de la noticia</b>: <a href="$1" target="_blank" rel=\"nofollow\">$2</a></p>',
                'content' => '$1$2'
            ],
            'image' => [
                'pattern' => '/\[img\](.*?)\[\/img\]/s',
                'replace' => "<picture><img class=\"img-fluid bcc-img w-100 mb-2 rounded border\" src=\"/storage/image/single/$1/image.jpg/\" image-attachment=\"$1\"/></picture>",
                'content' => '$1'
            ],
            'image-2' => [
                'pattern' => '/\[img\=(.*?)\](.*?)\[\/img\]/s',
                'replace' => "<picture><img class=\"img-fluid bcc-img w-100 mb-2 rounded border\" src=\"$1\" image-attachment=\"$1\"/></picture>",
                'content' => '$1'
            ],
            'photo-acredited' => [
                'pattern' => '/\[photo\=(.*?)\](.*?)\[\/photo\]/s',
                'replace' => ""
                    . "<figure class=\"figure no-margin no -padding w-100\">"
                    . "   <img class=\"img-fluid bcc-img\" src=\"" . base_url("/storage/image/single/$1/image.jpg") . "/\" image-attachment=\"$1\"/>"
                    . "   <figcaption class=\"figure-caption text-right\">© $2</figcaption>"
                    . "</figure>",
                'content' => '$1$2'
            ],
            'br' => [
                'pattern' => '/\[\/br\]/s',
                'replace' => '</br>',
                'content' => '$1'
            ],
            'hr' => [
                'pattern' => '/\[\/hr\]/s',
                'replace' => "</hr class=\"bbc\">",
                'content' => '$1'
            ],
            'orderedlistnumerical' => [
                'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
                'replace' => '<ol>$1</ol>',
                'content' => '$1'
            ],
            'orderedlistalpha' => [
                'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
                'replace' => '<ol type="a">$1</ol>',
                'content' => '$1'
            ],
            'unorderedlist' => [
                'pattern' => '/\[list\](.*?)\[\/list\]/s',
                'replace' => '<ul>$1</ul>',
                'content' => '$1'
            ],
            'unorderedlist2' => [
                'pattern' => '/\[ul\](.*?)\[\/ul\]/s',
                'replace' => "<ul class=\"bbc\">$1</ul>",
                'content' => '$1'
            ],
            'orderedlistx' => [
                'pattern' => '/\[ol\](.*?)\[\/ol\]/s',
                'replace' => "<ol class=\"bbc\">$1</ol>",
                'content' => '$1'
            ],
            'orderedcapitular' => [
                'pattern' => '/\[ol type=(.*?)\](.*?)\[\/ol\]/s',
                'replace' => "<ol type=\"$1\" class=\"bbc\">$2</ol>",
                'content' => '$1$2'
            ],
            'listitem' => [
                'pattern' => '/\[\*\](.*)/',
                'replace' => '<li>$1</li>',
                'content' => '$1'
            ],
            'listitem2' => [
                'pattern' => '/\[li\](.*?)\[\/li\]/s',
                'replace' => '<li>$1</li>',
                'content' => '$1'
            ],
            'youtube-1' => [
                'pattern' => '/\[youtube\]https:\/\/youtu.be\/(.*?)\[\/youtube\]/s',
                'replace' => '<iframe width="560" height="315" src="//www.youtube-nocookie.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                'content' => '$1'
            ],
            'youtube-2' => [
                'pattern' => '/\[youtube\]https:\/\/www.youtube.com\/watch?v=\/(.*?)\&feature=emb_logo\[\/youtube\]/s',
                'replace' => '<iframe width="560" height="315" src="//www.youtube-nocookie.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                'content' => '$1'
            ],
            'youtube-3' => [
                'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
                'replace' => '<iframe width="560" height="315" src="//www.youtube-nocookie.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
                'content' => '$1'
            ],
            'twitter-1' => [
                'pattern' => '/\[twitter\](.*?)\[\/twitter\]/s',
                'replace' => '<blockquote class="twitter-tweet"><p lang="en" dir="ltr"><a href="$1?ref_src=twsrc^tfw">Elon Musk</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> ',
                'content' => '$1'
            ],
            'instagram-1' => [
                'pattern' => '/\[instagram\](.*?)\[\/instagram\]/s',
                'replace' => "<blockquote class=\"instagram-media\" data-instgrm-captioned data-instgrm-permalink=\"https://www.instagram.com/p/CQP6G-eHvhY/?utm_source=ig_embed&amp;utm_campaign=loading\" data-instgrm-version=\"13\" style=\" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);\"><div style=\"padding:16px;\"> <a href=\"https://www.instagram.com/p/CQP6G-eHvhY/?utm_source=ig_embed&amp;utm_campaign=loading\" style=\" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;\" target=\"_blank\"> <div style=\" display: flex; flex-direction: row; align-items: center;\"> <div style=\"background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;\"></div> <div style=\"display: flex; flex-direction: column; flex-grow: 1; justify-content: center;\"> <div style=\" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;\"></div> <div style=\" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;\"></div></div></div><div style=\"padding: 19% 0;\"></div> <div style=\"display:block; height:50px; margin:0 auto 12px; width:50px;\"><svg width=\"50px\" height=\"50px\" viewBox=\"0 0 60 60\" version=\"1.1\" xmlns=\"https://www.w3.org/2000/svg\" xmlns:xlink=\"https://www.w3.org/1999/xlink\"><g stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\"><g transform=\"translate(-511.000000, -20.000000)\" fill=\"#000000\"><g><path d=\"M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631\"></path></g></g></g></svg></div><div style=\"padding-top: 8px;\"> <div style=\" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;\"> Ver esta publicación en Instagram</div></div><div style=\"padding: 12.5% 0;\"></div> <div style=\"display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;\"><div> <div style=\"background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);\"></div> <div style=\"background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;\"></div> <div style=\"background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);\"></div></div><div style=\"margin-left: 8px;\"> <div style=\" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;\"></div> <div style=\" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)\"></div></div><div style=\"margin-left: auto;\"> <div style=\" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);\"></div> <div style=\" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);\"></div> <div style=\" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);\"></div></div></div> <div style=\"display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;\"> <div style=\" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;\"></div> <div style=\" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;\"></div></div></a><p style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;\"><a href=\"https://www.instagram.com/p/CQP6G-eHvhY/?utm_source=ig_embed&amp;utm_campaign=loading\" style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;\" target=\"_blank\">Una publicación compartida de Sofia Vergara (@sofiavergara)</a></p></div></blockquote> <script async src=\"//www.instagram.com/embed.js\"></script>",
                'content' => '$1'
            ],
            'sub' => [
                'pattern' => '/\[sub\](.*?)\[\/sub\]/s',
                'replace' => '<sub>$1</sub>',
                'content' => '$1'
            ],
            'sup' => [
                'pattern' => '/\[sup\](.*?)\[\/sup\]/s',
                'replace' => '<sup>$1</sup>',
                'content' => '$1'
            ],
            'small' => [
                'pattern' => '/\[small\](.*?)\[\/small\]/s',
                'replace' => '<small>$1</small>',
                'content' => '$1'
            ],
            'table' => [
                'pattern' => '/\[table\](.*?)\[\/table\]/s',
                'replace' => '<table class="table table-striped table-bordered dataTable dtr-inline">$1</table>',
                'content' => '$1',
            ],
            'table-row' => [
                'pattern' => '/\[tr\](.*?)\[\/tr\]/s',
                'replace' => '<tr>$1</tr>',
                'content' => '$1',
            ],
            'table-header' => [
                'pattern' => '/\[th\](.*?)\[\/th\]/s',
                'replace' => '<th>$1</th>',
                'content' => '$1',
            ],
            'table-data' => [
                'pattern' => '/\[td\](.*?)\[\/td\]/s',
                'replace' => '<td>$1</td>',
                'content' => '$1',
            ],
            'markdown' => [
                'pattern' => '/\[markdown\](.*?)\[\/markdown\]/s',
                'replace' => "<article class=\"markdown\">$1</article>",
                'content' => '$1',
            ],
            'code' => [
                'pattern' => '/\[code\](.*?)\[\/code\]/s',
                'replace' => "<code class=\"bbc-code\">$1</code>",
                'content' => '$1',
            ],
            'code-ssh' => [
                'pattern' => '/\[code-ssh\](.*?)\[\/code-ssh\]/s',
                'replace' => "<textarea class=\"code-ssh\">$1</textarea>",
                'content' => '$1',
            ],
            'code-php' => [
                'pattern' => '/\[code-php\](.*?)\[\/code-php\]/s',
                'replace' => "<textarea class=\"code-php\">$1</textarea>",
                'content' => '$1',
            ],
            'code-html' => [
                'pattern' => '/\[code-html\](.*?)\[\/code-html\]/s',
                'replace' => "<textarea class=\"code-html\">$1</textarea>",
                'content' => '$1',
            ],
            'code-js' => [
                'pattern' => '/\[code-js\](.*?)\[\/code-js\]/s',
                'replace' => "<textarea class=\"code-js\">$1</textarea>",
                'content' => '$1',
            ],
            'code-sql' => [
                'pattern' => '/\[code-sql\](.*?)\[\/code-sql\]/s',
                'replace' => "<textarea class=\"code-sql\">$1</textarea>",
                'content' => '$1',
            ],
            'codecss' => [
                'pattern' => '/\[code-css\](.*?)\[\/code-css\]/s',
                'replace' => "<textarea class=\"code-css\">$1</textarea>",
                'content' => '$1',
            ],
            'percentage' => [
                'pattern' => '/\[percentage\](.*?)\[\/percentage\]/s',
                'replace' => "<b>$1&percnt;</b>",
                'content' => '$1',
            ],
            'keyword-1' => [
                'pattern' => '/\[keyword\](.*?)\[\/keyword\]/s',
                'replace' => "<a href=\"https://" . DOMAIN . "/social/keywords/view/$1\" class=\"keyword\">$1</a>",
                'content' => '$1',
            ],
            'keyword-2' => [
                'pattern' => '/\[keyword\=(.*?)\](.*?)\[\/keyword\]/s',
                'replace' => "<a href=\"https://" . DOMAIN . "/social/keywords/view/$2\" class=\"keyword\">$2</a>"
                    . "<sup id=\"cite-$1\" class=\"reference separada\">"
                    . "<a href=\"" . self::$url . "#note-$1\"><span class=\"corchete-llamada\">[</span>$1<span class=\"corchete-llamada\">]</span></a>"
                    . "</sup>",
                'content' => '$1',
            ],
            'video' => [
                'pattern' => '/\[video\](.*?)\[\/video\]/s',
                'replace' => "<video controls width=\"100%\"><source src=\"$1\" type=\"video/mp4\"></video>",
                'content' => '$1',
            ],
            'example' => [
                'pattern' => '/\[example\](.*?)\[\/example\]/s',
                'replace' => "<div class=\"example\">$1</div>",
                'content' => '$1',
            ],
            'CC-BY-NC-SA-ALEXIS' => [
                'pattern' => '/\[ALEXIS-CC-BY-NC-SA]/s',
                'replace' => "<img src=\"/themes/assets/images/alexis-cc-by-nc-sa.png\" style=\"width:100%; padding-top:10px;\"/>",
                'content' => '$1',
            ]
        ]);
    }

    public function get_VideoCallback($matches)
    {
        $c = "";
        if (is_array($matches) && !empty($matches[1])) {
            $mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
            $attachment = $mattachments->find($matches[1]);
            if (is_array($attachment) && !empty($attachment['file'])) {
                $uri=cdn_url($attachment["file"]);
                $c .= "<div  class=\"embed-responsive embed-responsive-16by9 mb-3\">";
                $c .= "<video";
                $c .= "    id=\"fm-video-{$matches[1]}\" ";
                $c .= "    class=\"video-js vjs-fluid skin-2\"";
                $c .= "    controls";
                $c .= "    preload=\"auto\"";
                $c .= "    width=\"800\"";
                $c .= "    height=\"600\"";
                $c .= "    poster=\"\"";
                $c .= "    data-setup=''>";
                $c .= "  <source src=\"{$uri}\" type=\"video/mp4\"></source>";
                //$c .= "  <source src=\"//vjs.zencdn.net/v/oceans.webm\" type=\"video/webm\"></source>";
                //$c .= "  <source src=\"//vjs.zencdn.net/v/oceans.ogv\" type=\"video/ogg\"></source>";
                $c .= "  <p class=\"vjs-no-js\">";
                $c .= "    To view this video please enable JavaScript, and consider upgrading to a";
                $c .= "    web browser that";
                $c .= "    <a href=\"https://videojs.com/html5-video-support/\" target=\"_blank\">";
                $c .= "      supports HTML5 video";
                $c .= "    </a>";
                $c .= "  </p>";
                $c .= "</video>";
                $c .= "</div>";
                $c .= "<script>";
                $c .= "var player=videojs('fm-video-{$matches[1]}',{fluid:true});";
                $c .= "</script>";
            }
        }
        return ($c);
    }


    public function get_ImageCallback($matches)
    {
        $c = "";
        if (is_array($matches) && !empty($matches[1])) {
            $mattachments = model("App\Modules\Storage\Models\Storage_Attachments");
            $attachment = $mattachments->find($matches[1]);
            if (is_array($attachment) && !empty($attachment['file'])) {
                $uri = cdn_url($attachment["file"]);
                $c .= "<div class=\"embed-responsive embed-responsive-16by9\">";
                $c .= "<picture>";
                $c .= "<img class=\"img-fluid bcc-img w-100 mb-2 rounded border\" src=\"{$uri}\"/>";
                $c .= "</picture>";
                $c .= "</div>";
            }
        }
        return ($c);
    }


    public function get_CodeCallback($matches)
    {
        $c = "";
        if (is_array($matches) && !empty($matches[1])) {
            $c .= "<span class=\"bbc-code\">" . ($matches[1]) . "</span>";
        }
        return ($c);
    }

    public function get_MarkdownCallback($matches)
    {
        $md = new \App\Libraries\Markdown();
        $c = "";
        if (is_array($matches) && !empty($matches[1])) {
            $c .= $md->text($matches[1]);
        }
        return ($c);
    }


}

?>