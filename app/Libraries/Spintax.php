<?php

namespace App\Libraries;

/**
 *
 * Example:
 * $spintax = new Spintax();
 * $string = '{Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {Smith|Williams|Davis}!';
 * echo $spintax->process($string);
 * echo $spintax->process('{Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}');
 */
class Spintax
{

    public function replace($text)
    {
        $text = $this->process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }

    public function process($text)
    {
        return preg_replace_callback('/\{(((?>[^\{\}]+)|(?R))*?)\}/x', array($this, 'replace'), $text);
    }

    function permute(&$arr, &$res, $cur = "", $n = 0)
    {
        if ($n == count($arr)) {
            // we are past the end of the array... push the results
            $res[] = $cur;
        } else {
            //permute one level down the array
            foreach ($arr[$n] as $term) {
                permute($arr, $res, $cur . $term, $n + 1);
            }
        }
    }

}

?>