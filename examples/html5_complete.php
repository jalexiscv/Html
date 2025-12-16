<?php
require_once __DIR__ . '/../autoload.php';

use Higgs\Html\Html;

try {
    echo "--- Testing Metadata ---\n";
    echo Html::title("Página de Prueba") . "\n";
    echo Html::base("https://example.com", "_blank") . "\n";

    echo "\n--- Testing Sectioning ---\n";
    echo Html::address([], "123 Calle Falsa") . "\n";
    echo Html::hgroup([], Html::h1("Titulo") . Html::h2("Subtitulo")) . "\n";

    echo "\n--- Testing Inline Semantics ---\n";
    echo Html::abbr("HTML", "HyperText Markup Language") . "\n";
    echo Html::b("Bold") . "\n";
    echo Html::data("12345", "Product 1") . "\n";
    echo Html::del("Borrado", null, "2023-01-01") . "\n";
    echo Html::ins("Insertado", null, "2023-01-02") . "\n";
    echo Html::time("2023-10-10", "2023-10-10") . "\n";
    echo Html::mark("Resaltado") . "\n";
    echo Html::ruby(Html::span([], "漢") . Html::rp("(") . Html::rt("kan") . Html::rp(")")) . "\n";
    echo Html::wbr() . "\n";

    echo "\n--- Testing Embedded ---\n";
    echo Html::picture(Html::source("img.webp") . Html::img("img.jpg")) . "\n";
    echo Html::map("mimapa", Html::area(['coords' => '0,0,10,10'])) . "\n";
    echo Html::template(Html::div([], "Hidden content")) . "\n";
    echo Html::slot("header", "Default content") . "\n";

    echo "\n--- Testing Table Atomic ---\n";
    echo Html::table([], [], ['summary' => 'Wrapper test']) // Use wrapper to check trait integration
        ->addChild(Html::caption("Tabla Atómica"))
        ->addChild(Html::colgroup(Html::col(['span' => 2])))
        ->addChild(Html::thead(Html::tr(Html::th("Col1") . Html::th("Col2"))))
        ->addChild(Html::tbody(Html::tr(Html::td("Data1") . Html::td("Data2"))))
        ->render() . "\n";

    echo "\n--- Testing Form Atomic ---\n";
    echo Html::label("list", "Choose:") . "\n";
    echo Html::input("text", "browser", null, ['list' => 'browsers']) . "\n";
    echo Html::datalist(
        "browsers",
        Html::option("Chrome", "chrome") .
            Html::option("Firefox", "firefox")
    ) . "\n";
    echo Html::output("a b", "Result") . "\n";
    echo Html::select("cars", [], null)
        ->addChild(Html::optgroup("Swedish", Html::option("Volvo", "volvo")))
        ->render() . "\n";

    echo "\n[SUCCESS] All tags generated without errors.\n";
} catch (Throwable $e) {
    echo "\n[ERROR] " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
    exit(1);
}
