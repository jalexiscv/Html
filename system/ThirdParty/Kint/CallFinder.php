<?php
declare(strict_types=1);

namespace Kint;
class CallFinder
{
    private static $ignore = [T_CLOSE_TAG => true, T_COMMENT => true, T_DOC_COMMENT => true, T_INLINE_HTML => true, T_OPEN_TAG => true, T_OPEN_TAG_WITH_ECHO => true, T_WHITESPACE => true,];
    private static $operator = [T_AND_EQUAL => true, T_BOOLEAN_AND => true, T_BOOLEAN_OR => true, T_ARRAY_CAST => true, T_BOOL_CAST => true, T_CLASS => true, T_CLONE => true, T_CONCAT_EQUAL => true, T_DEC => true, T_DIV_EQUAL => true, T_DOUBLE_CAST => true, T_FUNCTION => true, T_INC => true, T_INCLUDE => true, T_INCLUDE_ONCE => true, T_INSTANCEOF => true, T_INT_CAST => true, T_IS_EQUAL => true, T_IS_GREATER_OR_EQUAL => true, T_IS_IDENTICAL => true, T_IS_NOT_EQUAL => true, T_IS_NOT_IDENTICAL => true, T_IS_SMALLER_OR_EQUAL => true, T_LOGICAL_AND => true, T_LOGICAL_OR => true, T_LOGICAL_XOR => true, T_MINUS_EQUAL => true, T_MOD_EQUAL => true, T_MUL_EQUAL => true, T_NEW => true, T_OBJECT_CAST => true, T_OR_EQUAL => true, T_PLUS_EQUAL => true, T_REQUIRE => true, T_REQUIRE_ONCE => true, T_SL => true, T_SL_EQUAL => true, T_SR => true, T_SR_EQUAL => true, T_STRING_CAST => true, T_UNSET_CAST => true, T_XOR_EQUAL => true, T_POW => true, T_POW_EQUAL => true, T_SPACESHIP => true, T_DOUBLE_ARROW => true, '!' => true, '%' => true, '&' => true, '*' => true, '+' => true, '-' => true, '.' => true, '/' => true, ':' => true, '<' => true, '=' => true, '>' => true, '?' => true, '^' => true, '|' => true, '~' => true,];
    private static $strip = ['(' => true, ')' => true, '[' => true, ']' => true, '{' => true, '}' => true, T_OBJECT_OPERATOR => true, T_DOUBLE_COLON => true, T_NS_SEPARATOR => true,];
    private static $classcalls = [T_DOUBLE_COLON => true, T_OBJECT_OPERATOR => true,];
    private static $namespace = [T_STRING => true,];

    public static function getFunctionCalls(string $source, int $line, $function): array
    {
        static $up = ['(' => true, '[' => true, '{' => true, T_CURLY_OPEN => true, T_DOLLAR_OPEN_CURLY_BRACES => true,];
        static $down = [')' => true, ']' => true, '}' => true,];
        static $modifiers = ['!' => true, '@' => true, '~' => true, '+' => true, '-' => true,];
        static $identifier = [T_DOUBLE_COLON => true, T_STRING => true, T_NS_SEPARATOR => true,];
        if (KINT_PHP74) {
            self::$operator[T_FN] = true;
            self::$operator[T_COALESCE_EQUAL] = true;
        }
        if (KINT_PHP80) {
            $up[T_ATTRIBUTE] = true;
            self::$operator[T_MATCH] = true;
            self::$strip[T_NULLSAFE_OBJECT_OPERATOR] = true;
            self::$classcalls[T_NULLSAFE_OBJECT_OPERATOR] = true;
            self::$namespace[T_NAME_FULLY_QUALIFIED] = true;
            self::$namespace[T_NAME_QUALIFIED] = true;
            self::$namespace[T_NAME_RELATIVE] = true;
            $identifier[T_NAME_FULLY_QUALIFIED] = true;
            $identifier[T_NAME_QUALIFIED] = true;
            $identifier[T_NAME_RELATIVE] = true;
        }
        $tokens = \token_get_all($source);
        $cursor = 1;
        $function_calls = [];
        $prev_tokens = [null, null, null];
        if (\is_array($function)) {
            $class = \explode('\\', $function[0]);
            $class = \strtolower(\end($class));
            $function = \strtolower($function[1]);
        } else {
            $class = null;
            $function = \strtolower($function);
        }
        foreach ($tokens as $index => $token) {
            if (!\is_array($token)) {
                continue;
            }
            $cursor += \substr_count($token[1], "\n");
            if ($cursor > $line) {
                break;
            }
            if (isset(self::$ignore[$token[0]])) {
                continue;
            }
            $prev_tokens = [$prev_tokens[1], $prev_tokens[2], $token];
            if (!isset(self::$namespace[$token[0]])) {
                continue;
            }
            $ns = \explode('\\', \strtolower($token[1]));
            if (\end($ns) !== $function) {
                continue;
            }
            $nextReal = self::realTokenIndex($tokens, $index);
            if (!isset($nextReal, $tokens[$nextReal]) || '(' !== $tokens[$nextReal]) {
                continue;
            }
            if (null === $class) {
                if ($prev_tokens[1] && isset(self::$classcalls[$prev_tokens[1][0]])) {
                    continue;
                }
            } else {
                if (!$prev_tokens[1] || T_DOUBLE_COLON !== $prev_tokens[1][0]) {
                    continue;
                }
                if (!$prev_tokens[0] || !isset(self::$namespace[$prev_tokens[0][0]])) {
                    continue;
                }
                $ns = \explode('\\', \strtolower($prev_tokens[0][1]));
                if (\end($ns) !== $class) {
                    continue;
                }
            }
            $inner_cursor = $cursor;
            $depth = 1;
            $offset = $nextReal + 1;
            $instring = false;
            $realtokens = false;
            $paramrealtokens = false;
            $params = [];
            $shortparam = [];
            $param_start = $offset;
            while (isset($tokens[$offset])) {
                $token = $tokens[$offset];
                if (\is_array($token)) {
                    $inner_cursor += \substr_count($token[1], "\n");
                }
                if (!isset(self::$ignore[$token[0]]) && !isset($down[$token[0]])) {
                    $paramrealtokens = $realtokens = true;
                }
                if (isset($up[$token[0]])) {
                    if (1 === $depth) {
                        $shortparam[] = $token;
                        $realtokens = false;
                    }
                    ++$depth;
                } elseif (isset($down[$token[0]])) {
                    --$depth;
                    if (1 === $depth) {
                        if ($realtokens) {
                            $shortparam[] = '...';
                        }
                        $shortparam[] = $token;
                    }
                } elseif ('"' === $token[0]) {
                    if ($instring) {
                        --$depth;
                        if (1 === $depth) {
                            $shortparam[] = '...';
                        }
                    } else {
                        ++$depth;
                    }
                    $instring = !$instring;
                    $shortparam[] = '"';
                } elseif (1 === $depth) {
                    if (',' === $token[0]) {
                        $params[] = ['full' => \array_slice($tokens, $param_start, $offset - $param_start), 'short' => $shortparam,];
                        $shortparam = [];
                        $paramrealtokens = false;
                        $param_start = $offset + 1;
                    } elseif (T_CONSTANT_ENCAPSED_STRING === $token[0] && \strlen($token[1]) > 2) {
                        $shortparam[] = $token[1][0] . '...' . $token[1][0];
                    } else {
                        $shortparam[] = $token;
                    }
                }
                if ($depth <= 0) {
                    if ($paramrealtokens) {
                        $params[] = ['full' => \array_slice($tokens, $param_start, $offset - $param_start), 'short' => $shortparam,];
                    }
                    break;
                }
                ++$offset;
            }
            if ($inner_cursor < $line) {
                continue;
            }
            foreach ($params as &$param) {
                $name = self::tokensFormatted($param['short']);
                $expression = false;
                foreach ($name as $token) {
                    if (self::tokenIsOperator($token)) {
                        $expression = true;
                        break;
                    }
                }
                $param = ['name' => self::tokensToString($name), 'path' => self::tokensToString(self::tokensTrim($param['full'])), 'expression' => $expression,];
            }
            if (KINT_PHP81 && 1 === \count($params) && '...' === \reset($params)['path']) {
                continue;
            }
            --$index;
            while (isset($tokens[$index])) {
                if (!isset(self::$ignore[$tokens[$index][0]]) && !isset($identifier[$tokens[$index][0]])) {
                    break;
                }
                --$index;
            }
            $mods = [];
            while (isset($tokens[$index])) {
                if (isset(self::$ignore[$tokens[$index][0]])) {
                    --$index;
                    continue;
                }
                if (isset($modifiers[$tokens[$index][0]])) {
                    $mods[] = $tokens[$index];
                    --$index;
                    continue;
                }
                break;
            }
            $function_calls[] = ['parameters' => $params, 'modifiers' => $mods,];
        }
        return $function_calls;
    }

    private static function realTokenIndex(array $tokens, int $index): ?int
    {
        ++$index;
        while (isset($tokens[$index])) {
            if (!isset(self::$ignore[$tokens[$index][0]])) {
                return $index;
            }
            ++$index;
        }
        return null;
    }

    private static function tokenIsOperator($token): bool
    {
        return '...' !== $token && isset(self::$operator[$token[0]]);
    }

    private static function tokensToString(array $tokens): string
    {
        $out = '';
        foreach ($tokens as $token) {
            if (\is_string($token)) {
                $out .= $token;
            } else {
                $out .= $token[1];
            }
        }
        return $out;
    }

    private static function tokensTrim(array $tokens): array
    {
        foreach ($tokens as $index => $token) {
            if (isset(self::$ignore[$token[0]])) {
                unset($tokens[$index]);
            } else {
                break;
            }
        }
        $tokens = \array_reverse($tokens);
        foreach ($tokens as $index => $token) {
            if (isset(self::$ignore[$token[0]])) {
                unset($tokens[$index]);
            } else {
                break;
            }
        }
        return \array_reverse($tokens);
    }

    private static function tokensFormatted(array $tokens): array
    {
        $tokens = self::tokensTrim($tokens);
        $space = false;
        $attribute = false;
        $ignorestrip = false;
        $output = [];
        $last = null;
        if (T_FUNCTION === $tokens[0][0] || (KINT_PHP74 && T_FN === $tokens[0][0]) || (KINT_PHP80 && T_MATCH === $tokens[0][0])) {
            $ignorestrip = true;
        }
        foreach ($tokens as $index => $token) {
            if (isset(self::$ignore[$token[0]])) {
                if ($space) {
                    continue;
                }
                $next = self::realTokenIndex($tokens, $index);
                if (null === $next) {
                    break;
                }
                $next = $tokens[$next];
                if ($attribute && ']' === $last[0]) {
                    $attribute = false;
                } elseif (!$ignorestrip && isset(self::$strip[$last[0]]) && !self::tokenIsOperator($next)) {
                    continue;
                }
                if (!$ignorestrip && isset(self::$strip[$next[0]]) && $last && !self::tokenIsOperator($last)) {
                    continue;
                }
                $token = ' ';
                $space = true;
            } else {
                if (KINT_PHP80 && $last && T_ATTRIBUTE == $last[0]) {
                    $attribute = true;
                }
                $space = false;
                $last = $token;
            }
            $output[] = $token;
        }
        return $output;
    }
}