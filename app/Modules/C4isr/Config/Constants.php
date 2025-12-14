<?php

if (!defined('CONST_HUMAN_SKIN_COLORS')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Muy claro(Pantone 1-1-1)", "value" => "P111"),
        array("label" => "Claro(Pantone 1-1-4)", "value" => "P114"),
        array("label" => "Medio claro(Pantone 2-2-6)", "value" => "P226"),
        array("label" => "Medio(Pantone 4-4-4)", "value" => "P444"),
        array("label" => "Medio oscuro(Pantone 4-4-8)", "value" => "P448"),
        array("label" => "Oscuro(Pantone 6-6-10)", "value" => "P6610"),
        array("label" => "Muy oscuro(Pantone 7-7-10)", "value" => "P7710"),
    );
    define('CONST_HUMAN_SKIN_COLORS', $fields);
}

if (!defined('CONST_HUMAN_EYE_COLORS')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Negro", "value" => "black"),
        array("label" => "Marrón", "value" => "brown"),
        array("label" => "Avellana", "value" => "hazel"),
        array("label" => "Azul", "value" => "blue"),
        array("label" => "Verde", "value" => "green"),
        array("label" => "Gris", "value" => "gray"),
        array("label" => "Ámbar", "value" => "amber"),
    );
    define('CONST_HUMAN_EYE_COLORS', $fields);
}

if (!defined('CONST_HUMAN_EYE_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Almendrados", "value" => "almond"),
        array("label" => "Redondos", "value" => "round"),
        array("label" => "Hundidos", "value" => "deep_set"),
        array("label" => "Prominentes", "value" => "prominent"),
        array("label" => "Monólidos", "value" => "monolid"),
        array("label" => "Caídos", "value" => "downturned"),
        array("label" => "Levantados", "value" => "upturned"),
        array("label" => "Cerrados", "value" => "close_set"),
        array("label" => "Separados", "value" => "wide_set"),
    );
    define('CONST_HUMAN_EYE_SHAPES', $fields);
}
if (!defined('CONST_HUMAN_HAIR_COLORS')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Negro", "value" => "black"),
        array("label" => "Marrón oscuro", "value" => "dark_brown"),
        array("label" => "Marrón", "value" => "brown"),
        array("label" => "Marrón claro", "value" => "light_brown"),
        array("label" => "Rubio oscuro", "value" => "dark_blonde"),
        array("label" => "Rubio", "value" => "blonde"),
        array("label" => "Rubio claro", "value" => "light_blonde"),
        array("label" => "Pelirrojo", "value" => "red"),
        array("label" => "Gris", "value" => "gray"),
        array("label" => "Blanco", "value" => "white"),
    );
    define('CONST_HUMAN_HAIR_COLORS', $fields);
}
if (!defined('CONST_HUMAN_EYE_SIZES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Pequeños", "value" => "small"),
        array("label" => "Medianos", "value" => "medium"),
        array("label" => "Grandes", "value" => "large"),
    );
    define('CONST_HUMAN_EYE_SIZES', $fields);
}
if (!defined('CONST_HUMAN_HAIR_TYPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Liso", "value" => "straight"),
        array("label" => "Ondulado", "value" => "wavy"),
        array("label" => "Rizado", "value" => "curly"),
        array("label" => "Muy rizado", "value" => "very_curly"),
    );
    define('CONST_HUMAN_HAIR_TYPES', $fields);
}
if (!defined('CONST_HUMAN_HAIR_LENGTHS')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Rapado", "value" => "buzz_cut"),
        array("label" => "Corto", "value" => "short"),
        array("label" => "Mediano", "value" => "medium"),
        array("label" => "Largo", "value" => "long"),
        array("label" => "Muy largo", "value" => "very_long"),
    );
    define('CONST_HUMAN_HAIR_LENGTHS', $fields);
}
if (!defined('CONST_HUMAN_FACE_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Redonda", "value" => "round"),
        array("label" => "Ovalada", "value" => "oval"),
        array("label" => "Cuadrada", "value" => "square"),
        array("label" => "Rectangular", "value" => "rectangular"),
        array("label" => "Diamante", "value" => "diamond"),
        array("label" => "Triangular", "value" => "triangular"),
        array("label" => "Corazón", "value" => "heart"),
    );
    define('CONST_HUMAN_FACE_SHAPES', $fields);
}
if (!defined('CONST_HUMAN_NOSE_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Pequeña y recta", "value" => "small_straight"),
        array("label" => "Pequeña y respingona", "value" => "small_upturned"),
        array("label" => "Pequeña y aguileña", "value" => "small_hawk"),
        array("label" => "Mediana y recta", "value" => "medium_straight"),
        array("label" => "Mediana y respingona", "value" => "medium_upturned"),
        array("label" => "Mediana y aguileña", "value" => "medium_hawk"),
        array("label" => "Grande y recta", "value" => "large_straight"),
        array("label" => "Grande y respingona", "value" => "large_upturned"),
        array("label" => "Grande y aguileña", "value" => "large_hawk"),
    );
    define('CONST_HUMAN_NOSE_SHAPES', $fields);
}
if (!defined('CONST_HUMAN_EAR_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Pequeñas y redondeadas", "value" => "small_round"),
        array("label" => "Pequeñas y alargadas", "value" => "small_elongated"),
        array("label" => "Pequeñas y puntiagudas", "value" => "small_pointed"),
        array("label" => "Medianas y redondeadas", "value" => "medium_round"),
        array("label" => "Medianas y alargadas", "value" => "medium_elongated"),
        array("label" => "Medianas y puntiagudas", "value" => "medium_pointed"),
        array("label" => "Grandes y redondeadas", "value" => "large_round"),
        array("label" => "Grandes y alargadas", "value" => "large_elongated"),
        array("label" => "Grandes y puntiagudas", "value" => "large_pointed"),
    );
    define('CONST_HUMAN_EAR_SHAPES', $fields);
}
if (!defined('CONST_HUMAN_LIP_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Delgados y rectos", "value" => "thin_straight"),
        array("label" => "Delgados y curvados", "value" => "thin_curved"),
        array("label" => "Delgados y en forma de corazón", "value" => "thin_heart"),
        array("label" => "Medianos y rectos", "value" => "medium_straight"),
        array("label" => "Medianos y curvados", "value" => "medium_curved"),
        array("label" => "Medianos y en forma de corazón", "value" => "medium_heart"),
        array("label" => "Gruesos y rectos", "value" => "full_straight"),
        array("label" => "Gruesos y curvados", "value" => "full_curved"),
        array("label" => "Gruesos y en forma de corazón", "value" => "full_heart"),
    );
    define('CONST_HUMAN_LIP_SHAPES', $fields);
}

if (!defined('CONST_HUMAN_CHIN_SHAPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Pequeña y redondeada", "value" => "small_round"),
        array("label" => "Pequeña y cuadrada", "value" => "small_square"),
        array("label" => "Pequeña y puntiaguda", "value" => "small_pointed"),
        array("label" => "Mediana y redondeada", "value" => "medium_round"),
        array("label" => "Mediana y cuadrada", "value" => "medium_square"),
        array("label" => "Mediana y puntiaguda", "value" => "medium_pointed"),
        array("label" => "Grande y redondeada", "value" => "large_round"),
        array("label" => "Grande y cuadrada", "value" => "large_square"),
        array("label" => "Grande y puntiaguda", "value" => "large_pointed"),
    );
    define('CONST_HUMAN_CHIN_SHAPES', $fields);
}
if (!defined('CONST_HUMAN_FACIAL_HAIR_TYPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Sin vello facial", "value" => "none"),
        array("label" => "Bigote", "value" => "mustache"),
        array("label" => "Barba corta", "value" => "short_beard"),
        array("label" => "Barba mediana", "value" => "medium_beard"),
        array("label" => "Barba larga", "value" => "long_beard"),
        array("label" => "Barba completa", "value" => "full_beard"),
        array("label" => "Barba de candado", "value" => "goatee"),
        array("label" => "Perilla", "value" => "van_dyke"),
        array("label" => "Patillas", "value" => "sideburns"),
    );
    define('CONST_HUMAN_FACIAL_HAIR_TYPES', $fields);
}
if (!defined('CONST_HUMAN_EYEBROW_TYPES')) {
    $fields = array(
        array("label" => "- Seleccione uno -", "value" => ""),
        array("label" => "Sin cejas", "value" => "none"),
        array("label" => "Cejas finas", "value" => "thin"),
        array("label" => "Cejas medianas", "value" => "medium"),
        array("label" => "Cejas gruesas", "value" => "thick"),
        array("label" => "Cejas rectas", "value" => "straight"),
        array("label" => "Cejas curvadas", "value" => "curved"),
        array("label" => "Cejas en ángulo", "value" => "angled"),
        array("label" => "Cejas unidas", "value" => "unibrow"),
    );
    define('CONST_HUMAN_EYEBROW_TYPES', $fields);
}

if (!defined('SHODAN_API_KEY')) {
    define('SHODAN_API_KEY', "ApWJ249AiARJ8PrEIPm6ZuGLrEV0wqdg");
    define('SHODAN_API_URL', "https://api.shodan.io/shodan/host/search");
}
?>