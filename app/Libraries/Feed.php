<?php

namespace App\Libraries;

use Higgs\Config\Services;

class Feed
{

    public $title = "My feed title";
    public $description = "My feed description";
    public $link;
    public $logo;
    public $icon;
    public $pubdate;
    public $lang;
    public $charset = "utf-8";
    public $ctype = null;
    protected $items = array();
    protected $shortening = false;
    protected $shorteningLimit = 150;
    protected $dateFormat = "datetime";
    protected $namespaces = array();
    protected $customView = null;

    public function add($title, $author, $link, $pubdate, $description, $content = "", $cover = "", $enclosure = array())
    {

        if ($this->shortening) {
            $description = mb_substr($description, 0, $this->shorteningLimit, "UTF-8");
        }

        $this->items[] = array(
            'title' => $title,
            'author' => $author,
            'link' => $link,
            'pubdate' => $pubdate,
            'description' => $this->remove_special_characters($description),
            'content' => $content,
            "cover" => "https://" . DOMAIN . $cover,
            'enclosure' => $enclosure
        );
    }

    private function remove_special_characters($user_string)
    {
        $user_string = str_replace(array('[\', \']'), '', $user_string);
        $user_string = preg_replace('/\[.*\]/U', '', $user_string);
        $user_string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', ' ', $user_string);
        $user_string = htmlentities($user_string, ENT_COMPAT, 'utf-8');
        $user_string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $user_string);
        $user_string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), ' ', $user_string);
        return strtolower(trim($user_string, '-'));
    }

    public function addArray(array $a)
    {

        if ($this->shortening) {
            $a['description'] = mb_substr($a['description'], 0, $this->shorteningLimit, "UTF-8");
        }

        $this->items[] = $a;
    }

    public function render($format = null, $cache = null, $key = null)
    {
        $config = Services::request()->config;
        if ($format == null && $this->customView == null)
            $format = "atom";
        if ($this->customView == null)
            $this->customView = $format;
        if ($cache != null)
            $this->caching = $cache;
        if ($key != null)
            $this->cacheKey = $key;

        if ($this->ctype == null) {
            ($format == 'rss') ? $this->ctype = "application/rss+xml" : $this->ctype = "application/atom+xml";
        }

        if (empty($this->lang))
            $this->lang = $config("language");
        if (empty($this->link))
            $this->link = $config("base_url");
        if (empty($this->pubdate))
            $this->pubdate = date("D, d M Y H:i:s O");

        foreach ($this->items as $k => $v) {
            $this->items[$k]['title'] = html_entity_decode(strip_tags($this->items[$k]['title']));
            $this->items[$k]['pubdate'] = $this->formatDate($this->items[$k]['pubdate'], $format);
        }

        $channel = array(
            'title' => html_entity_decode(strip_tags($this->title)),
            'description' => $this->description,
            'logo' => $this->logo,
            'icon' => $this->icon,
            'link' => $this->link,
            'pubdate' => $this->formatDate($this->pubdate, $format),
            'lang' => $this->lang
        );

        $viewData = array(
            'items' => $this->items,
            'channel' => $channel,
            'namespaces' => $this->getNamespaces(),
            'ctype' => $this->ctype,
            'charset' => $this->charset
        );
        if ($this->customView == "atom") {
            return ($this->generate_ATOM($viewData));
        } elseif ($this->customView == "facebook") {
            return ($this->generate_Facebook($viewData));
        } elseif ($this->customView == "news") {
            return ($this->generate_News($viewData));
        } else {
            return ($this->generate_RSS($viewData));
        }
    }

    protected function formatDate($date, $format = "atom")
    {
        if ($format == "atom") {
            switch ($this->dateFormat) {
                case "carbon":
                    $date = date("c", strtotime($date->toDateTimeString()));
                    break;
                case "timestamp":
                    $date = date("c", $date);
                    break;
                case "datetime":
                    $date = date("c", strtotime($date));
                    break;
            }
        } else {
            switch ($this->dateFormat) {
                case "carbon":
                    $date = date("D, d M Y H:i:s O", strtotime($date->toDateTimeString()));
                    break;
                case "timestamp":
                    $date = date("D, d M Y H:i:s O", $date);
                    break;
                case "datetime":
                    $date = date("D, d M Y H:i:s O", strtotime($date));
                    break;
            }
        }


        return $date;
    }

    public function getNamespaces()
    {
        return $this->namespaces;
    }

    private function generate_ATOM($data)
    {
        $namespaces = $data["namespaces"];
        $channel = $data["channel"];
        $items = $data["items"];
        $c = "<?xml version=\"1.0\" encoding=\"utf-8\">\n";
        $c .= "<feed xmlns=\"http://www.w3.org/2005/Atom\"";
        foreach ($namespaces as $n) {
            $c .= " {$n}";
        }
        $c .= ">\n";
        $c .= "\t\t<title type=\"text\">{$channel['title']}</title>\n";
        $c .= "\t\t<subtitle type=\"html\"><![CDATA[{$channel['description']}]]></subtitle>\n";
        $c .= "\t\t<link href=\"{$channel['link']}\"></link>\n";
        $c .= "\t\t<id>{$channel['link']}</id>\n";
        $c .= "\t\t<link rel=\"alternate\" type=\"text/html\" href=\"{$channel['link']}\" ></link>\n";
        $c .= "\t\t<link rel=\"self\" type=\"application/atom+xml\" href=\"{$channel['link']}\"></link>\n";
        if (!empty($channel['logo'])) {
            $c .= "\t\t<logo>{$channel['logo']}</logo>\n";
        }
        if (!empty($channel['icon'])) {
            $c .= "\t\t<icon>{$channel['icon']}</icon>\n";
        }
        $c .= "\t\t<updated>{$channel['pubdate']}</updated>\n";
        foreach ($items as $item) {
            $c .= "\t\t<entry>\n";
            $c .= "\t\t\t<author><name>{$item['author']}</name></author>\n";
            $c .= "\t\t\t<title type=\"text\">{$item['title']}</title>\n";
            $c .= "\t\t\t<link rel=\"alternate\" type=\"text/html\" href=\"{$item['link']}\"></link>\n";
            $c .= "\t\t\t<id>{$item['link']}</id>\n";
            $c .= "\t\t\t<summary type=\"html\"><![CDATA[{$item['description']}]]></summary>\n";
            $c .= "\t\t\t<content type=\"html\"><![CDATA[{$item['content']}]]></content>\n";
            $c .= "\t\t\t<updated>{$item['pubdate']}</updated>\n";
            $c .= "\t\t</entry>\n";
        }
        $c .= "</feed>\n";
        return ($c);
    }

    private function generate_Facebook($data)
    {
        $channel = $data["channel"];
        $items = $data['items'];
        //header("Content-Type: '.$ctype."; charset='.$charset);
        $c = "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n";
        $c .= "\t\t<channel>\n";
        $c .= "\t\t\t<title>" . $channel['title'] . "</title>\n";
        $c .= "\t\t\t<link>" . $channel['link'] . "</link>\n";
        $c .= "\t\t\t<description>" . $channel['description'] . "</description>\n";
        if (!empty($channel['logo'])) {
            $c .= "\t\t\t<image>\n";
            $c .= "\t\t\t\t<url>" . $channel['logo'] . "</url>\n";
            $c .= "\t\t\t\t<title>" . $channel['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $channel['link'] . "</link>\n";
            $c .= "\t\t\t</image>";
        }
        $c .= "\t\t\t<language>" . $channel['lang'] . "</language>\n";
        $c .= "\t\t\t<lastBuildDate>" . $channel['pubdate'] . "</lastBuildDate>\n";
        foreach ($items as $item) {
            $c .= "\t\t\t<item>\n";
            $c .= "\t\t\t\t<title>" . $item['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $item['link'] . "</link>\n";
            $c .= "\t\t\t\t<guid isPermaLink = \"true\">" . md5($item['link']) . "</guid>\n";
            $c .= "\t\t\t\t<description><![CDATA[" . $item['description'] . "]]></description>\n";
            if (!empty($item['content'])) {
                $c .= "\t\t\t\t<content:encoded><![CDATA[\n";
                $c .= "\t\t\t\t<!doctype html>\n";
                $c .= "\t\t\t\t<html lang=\"es\" prefix=\"op: http://media.facebook.com/op#\">\n";
                $c .= "\t\t\t\t<head>\n";
                $c .= "\t\t\t\t<meta charset=\"utf-8\">\n";
                $c .= "\t\t\t\t<link rel=\"canonical\" href=\"{$item['link']}\">\n";
                $c .= "\t\t\t\t<meta property=\"op:markup_version\" content=\"v1.0\">\n";
                $c .= "\t\t\t\t<meta property=\"fb:article_style\" content=\"Normal\">\n";
                $c .= "\t\t\t\t<meta property=\"fb:op-recirculation-ads\" content=\"enable=true placement_id=2342212205890102_2342212239223432\">\n";
                $c .= "\t\t\t\t</head>\n";
                $c .= "\t\t\t\t<body>\n";
                $c .= "\t\t\t\t<article>\n";

                $op_published = date("D, d M Y H:i:s O", strtotime($item['pubdate']));
                $op_modified = date("D, d M Y H:i:s O", strtotime($item['pubdate']));
                $c .= "\t\t\t\t<header>\n";
                $c .= "\t\t\t\t\t<h1>{$item['title']}</h1>\n";
                $c .= "\t\t\t\t\t<time class=\"op-published\" datetime=\"{$op_published}\">{$op_published}</time>\n";
                $c .= "\t\t\t\t\t<time class=\"op-modified\" dateTime=\"{$op_modified}\">{$op_modified}</time>\n";
                $c .= "\t\t\t\t\t<address>\n";
                $c .= "\t\t\t\t\t<a rel=\"facebook\" href=\"https://www.facebook.com/bugavision\">Bugavision</a>\n";
                $c .= "\t\t\t\t\tEnjoy the videos and music you love, original content and share it all with friends, family and the world.\n";
                $c .= "\t\t\t\t\t</address>\n";
                $c .= "\t\t\t\t\t<address><a>Bugavision</a></address>\n";
                $c .= "\t\t\t\t\t<figure>\n";
                $c .= "\t\t\t\t\t\t<img src=\"{$item['cover']}\"/>\n";
                $c .= "\t\t\t\t\t\t<figcaption>{$item['title']}</figcaption>\n";
                $c .= "\t\t\t\t\t</figure>\n";
                $c .= "\t\t\t\t</header>\n";

                $c .= "\t\t\t\t{$item['content']}\n";

                $anno = date("Y");
                $c .= "\t\t\t\t<footer>\n";
                //$c .= "\t\t\t\t\t<aside>Higgs Tech</aside>\n";
                $c .= "\t\t\t\t\t<small>Copyright (C) {$anno} bugavision.com</small>\n";
                $c .= "\t\t\t\t</footer>\n";

                $c .= "\t\t\t\t</article>\n";
                $c .= "\t\t\t\t</body>\n";
                $c .= "\t\t\t\t</html>\n";
                $c .= "\t\t\t\t]]></content:encoded>\n";
            }
            $c .= "\t\t\t\t<dc:creator xmlns:dc=\"http://purl.org/dc/elements/1.1/\">" . $item['author'] . "</dc:creator>\n";
            $c .= "\t\t\t\t<pubDate>" . $item['pubdate'] . "</pubDate>\n";
            if (!empty($item['enclosure'])) {
                $c .= "\t\t\t\t<enclosure ";
                foreach ($item['enclosure'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:content'])) {
                $c .= "\t\t\t\t<media:content ";
                foreach ($item['media:content'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:thumbnail'])) {
                $c .= "\t\t\t\t<media:thumbnail ";
                foreach ($item['media:thumbnail'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:title'])) {
                $c .= "\t\t\t\t<media:title type=\"plain\">" . $item['media:title'] . "</media:title>\n";
            }
            if (!empty($item['media:description'])) {
                $c .= "\t\t\t\t<media:description type=\"plain\">" . $item['media:description'] . "</media:description>\n";
            }
            if (!empty($item['media:keywords'])) {
                $c .= "\t\t\t\t<media:keywords>" . $item['media:title'] . "</media:keywords>\n";
            }
            if (!empty($item['media:rating'])) {
                $c .= "\t\t\t\t<media:rating>" . $item['media:rating'] . "</media:rating>\n";
            }
            if (!empty($item['creativeCommons:license'])) {
                $c .= "\t\t\t\t<creativeCommons:license>" . $item['creativeCommons:license'] . "</creativeCommons:license>\n";
            }
            $c .= "\t\t\t</item>\n";
        }
        $c .= "\t\t</channel>\n";
        $c .= "</rss>\n";
        return ($c);
    }

    private function generate_News($data)
    {
        $channel = $data["channel"];
        $items = $data['items'];
        //header("Content-Type: '.$ctype."; charset='.$charset);
        $c = "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n";
        $c .= "\t\t<channel>\n";
        $c .= "\t\t\t<title>" . $channel['title'] . "</title>\n";
        $c .= "\t\t\t<link>" . $channel['link'] . "</link>\n";
        $c .= "\t\t\t<description>" . $channel['description'] . "</description>\n";
        if (!empty($channel['logo'])) {
            $c .= "\t\t\t<image>\n";
            $c .= "\t\t\t\t<url>" . $channel['logo'] . "</url>\n";
            $c .= "\t\t\t\t<title>" . $channel['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $channel['link'] . "</link>\n";
            $c .= "\t\t\t</image>";
        }
        $c .= "\t\t\t<language>" . $channel['lang'] . "</language>\n";
        $c .= "\t\t\t<lastBuildDate>" . $channel['pubdate'] . "</lastBuildDate>\n";
        foreach ($items as $item) {
            $c .= "\t\t\t<item>\n";
            $c .= "\t\t\t\t<title>" . $item['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $item['link'] . "</link>\n";
            $c .= "\t\t\t\t<guid isPermaLink = \"true\">" . md5($item['link']) . "</guid>\n";
            $c .= "\t\t\t\t<description><![CDATA[" . $item['description'] . "]]></description>\n";
            if (!empty($item['content'])) {
                $c .= "\t\t\t\t<content:encoded><![CDATA[\n";
                $c .= "\t\t\t\t<!doctype html>\n";
                $c .= "\t\t\t\t<html lang=\"es\" prefix=\"op: http://media.facebook.com/op#\">\n";
                $c .= "\t\t\t\t<head>\n";
                $c .= "\t\t\t\t<meta charset=\"utf-8\">\n";
                $c .= "\t\t\t\t<link rel=\"canonical\" href=\"{$item['link']}\">\n";
                $c .= "\t\t\t\t<meta property=\"op:markup_version\" content=\"v1.0\">\n";
                $c .= "\t\t\t\t<meta property=\"fb:article_style\" content=\"Normal\">\n";
                $c .= "\t\t\t\t</head>\n";
                $c .= "\t\t\t\t<body>\n";
                $c .= "\t\t\t\t<article>\n";

                $op_published = date("D, d M Y H:i:s O", strtotime($item['pubdate']));
                $op_modified = date("D, d M Y H:i:s O", strtotime($item['pubdate']));
                $c .= "\t\t\t\t<header>\n";
                $c .= "\t\t\t\t\t<h1>{$item['title']}</h1>\n";
                $c .= "\t\t\t\t\t<time class=\"op-published\" datetime=\"{$op_published}\">{$op_published}</time>\n";
                $c .= "\t\t\t\t\t<time class=\"op-modified\" dateTime=\"{$op_modified}\">{$op_modified}</time>\n";
                $c .= "\t\t\t\t\t<address>\n";
                $c .= "\t\t\t\t\t<a rel=\"facebook\" href=\"https://www.facebook.com/bugavision\">Bugavision</a>\n";
                $c .= "\t\t\t\t\tEnjoy the videos and music you love, original content and share it all with friends, family and the world.\n";
                $c .= "\t\t\t\t\t</address>\n";
                $c .= "\t\t\t\t\t<address><a>Bugavision</a></address>\n";
                $c .= "\t\t\t\t\t<figure>\n";
                $c .= "\t\t\t\t\t\t<img src=\"{$item['cover']}\"/>\n";
                $c .= "\t\t\t\t\t\t<figcaption>{$item['title']}</figcaption>\n";
                $c .= "\t\t\t\t\t</figure>\n";
                $c .= "\t\t\t\t</header>\n";

                $c .= "\t\t\t\t{$item['content']}\n";

                $anno = date("Y");
                $c .= "\t\t\t\t<footer>\n";
                //$c .= "\t\t\t\t\t<aside>Higgs Tech</aside>\n";
                $c .= "\t\t\t\t\t<small>Copyright (C) {$anno} bugavision.com</small>\n";
                $c .= "\t\t\t\t</footer>\n";

                $c .= "\t\t\t\t</article>\n";
                $c .= "\t\t\t\t</body>\n";
                $c .= "\t\t\t\t</html>\n";
                $c .= "\t\t\t\t]]></content:encoded>\n";
            }
            $c .= "\t\t\t\t<dc:creator xmlns:dc=\"http://purl.org/dc/elements/1.1/\">" . $item['author'] . "</dc:creator>\n";
            $c .= "\t\t\t\t<pubDate>" . $item['pubdate'] . "</pubDate>\n";
            if (!empty($item['enclosure'])) {
                $c .= "\t\t\t\t<enclosure ";
                foreach ($item['enclosure'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:content'])) {
                $c .= "\t\t\t\t<media:content ";
                foreach ($item['media:content'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:thumbnail'])) {
                $c .= "\t\t\t\t<media:thumbnail ";
                foreach ($item['media:thumbnail'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:title'])) {
                $c .= "\t\t\t\t<media:title type=\"plain\">" . $item['media:title'] . "</media:title>\n";
            }
            if (!empty($item['media:description'])) {
                $c .= "\t\t\t\t<media:description type=\"plain\">" . $item['media:description'] . "</media:description>\n";
            }
            if (!empty($item['media:keywords'])) {
                $c .= "\t\t\t\t<media:keywords>" . $item['media:title'] . "</media:keywords>\n";
            }
            if (!empty($item['media:rating'])) {
                $c .= "\t\t\t\t<media:rating>" . $item['media:rating'] . "</media:rating>\n";
            }
            if (!empty($item['creativeCommons:license'])) {
                $c .= "\t\t\t\t<creativeCommons:license>" . $item['creativeCommons:license'] . "</creativeCommons:license>\n";
            }
            $c .= "\t\t\t</item>\n";
        }
        $c .= "\t\t</channel>\n";
        $c .= "</rss>\n";
        return ($c);
    }

    private function generate_RSS($data)
    {
        $channel = $data["channel"];
        $items = $data['items'];
        //header("Content-Type: '.$ctype."; charset='.$charset);
        $c = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $c .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:media=\"http://search.yahoo.com/mrss/\"";
        foreach ($data['namespaces'] as $n) {
            $c .= " " . $n;
        }
        $c .= ">\n";
        $c .= "\t\t<channel>\n";
        $c .= "\t\t\t<title>" . $channel['title'] . "</title>\n";
        $c .= "\t\t\t<link><![CDATA[" . $channel['link'] . "]]></link>\n";
        $c .= "\t\t\t<description>" . $channel['description'] . "</description>\n";
        $c .= "\t\t\t<atom:link href=\"" . $channel['link'] . "\" rel=\"self\"></atom:link>\n";
        if (!empty($channel['logo'])) {
            $c .= "\t\t\t<image>\n";
            $c .= "\t\t\t\t<url>" . $channel['logo'] . "</url>\n";
            $c .= "\t\t\t\t<title>" . $channel['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $channel['link'] . "</link>\n";
            $c .= "\t\t\t</image>";
        }
        $c .= "\t\t\t<language>" . $channel['lang'] . "</language>\n";
        $c .= "\t\t\t<lastBuildDate>" . $channel['pubdate'] . "</lastBuildDate>\n";
        foreach ($items as $item) {
            $c .= "\t\t\t<item>\n";
            $c .= "\t\t\t\t<title>" . $item['title'] . "</title>\n";
            $c .= "\t\t\t\t<link>" . $item['link'] . "</link>\n";
            $c .= "\t\t\t\t<guid isPermaLink = \"true\">" . $item['link'] . "</guid>\n";
            $c .= "\t\t\t\t<description><![CDATA[" . $item['description'] . "]]></description>\n";
            if (!empty($item['content'])) {
                $c .= "\t\t\t\t<content:encoded><![CDATA[" . $item['content'] . "]]></content:encoded>\n";
            }
            $c .= "\t\t\t\t<dc:creator xmlns:dc=\"http://purl.org/dc/elements/1.1/\">" . $item['author'] . "</dc:creator>\n";
            $c .= "\t\t\t\t<pubDate>" . $item['pubdate'] . "</pubDate>\n";
            if (!empty($item['enclosure'])) {
                $c .= "\t\t\t\t<enclosure ";
                foreach ($item['enclosure'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:content'])) {
                $c .= "\t\t\t\t<media:content ";
                foreach ($item['media:content'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:thumbnail'])) {
                $c .= "\t\t\t\t<media:thumbnail ";
                foreach ($item['media:thumbnail'] as $k => $v) {
                    $c .= $k . "=\"" . $v . "\" ";
                }
                $c .= "/>\n";
            }
            if (!empty($item['media:title'])) {
                $c .= "\t\t\t\t<media:title type=\"plain\">" . $item['media:title'] . "</media:title>\n";
            }
            if (!empty($item['media:description'])) {
                $c .= "\t\t\t\t<media:description type=\"plain\">" . $item['media:description'] . "</media:description>\n";
            }
            if (!empty($item['media:keywords'])) {
                $c .= "\t\t\t\t<media:keywords>" . $item['media:title'] . "</media:keywords>\n";
            }
            if (!empty($item['media:rating'])) {
                $c .= "\t\t\t\t<media:rating>" . $item['media:rating'] . "</media:rating>\n";
            }
            if (!empty($item['creativeCommons:license'])) {
                $c .= "\t\t\t\t<creativeCommons:license>" . $item['creativeCommons:license'] . "</creativeCommons:license>\n";
            }
            $c .= "\t\t\t</item>\n";
        }
        $c .= "\t\t</channel>\n";
        $c .= "</rss>\n";
        return ($c);
    }

    public function link($url, $format = "atom")
    {

        if ($this->ctype == null) {
            ($format == 'rss') ? $type = "application/rss+xml" : $type = "application/atom+xml";
        } else {
            $type = $this->ctype;
        }

        return ("<link rel=\"alternate\" type=\"" . $type . "\" href=\"" . $url . "\" />");
    }

    public function setView($name = null)
    {
        $this->customView = $name;
    }

    public function setTextLimit($l = 150)
    {
        $this->shorteningLimit = $l;
    }

    public function setShortening($b = false)
    {
        $this->shortening = $b;
    }

    public function addNamespace($n)
    {
        $this->namespaces[] = $n;
    }

    public function setDateFormat($format = "datetime")
    {
        $this->dateFormat = $format;
    }

}

?>