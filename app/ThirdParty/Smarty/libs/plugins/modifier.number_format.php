<?php
function smarty_modifier_number_format(?float $num, int $decimals = 0, ?string $decimal_separator = ".", ?string $thousands_separator = ",")
{
    return number_format($num ?? 0.0, $decimals, $decimal_separator, $thousands_separator);
}