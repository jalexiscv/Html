<?php
$Authentication = new App\Libraries\Authentication();
$dates = new App\Libraries\Dates();
$prefix = "Wallet.Currencies";
$f = service("forms", array("lang" => "{$prefix}-"));
$model = model('App\Modules\Wallet\Models\Wallet_Currencies', true);
/** Fields **/
$d = array(
    "currency" => $f->get_Value("currency"),
    "name" => $f->get_Value("name"),
    "abbreviation" => $f->get_Value("abbreviation"),
    "icon" => $f->get_Value("icon"),
    "author" => $f->get_Value("author"),
);
$row = $model->where("currency", $d["currency"])->first();
/** Links **/
$link["continue"] = safe_strtolower("/{$module}/{$component}/list?time=" . time());
$link["duplicate"] = safe_strtolower("/{$module}/{$component}/view/{$d["currency"]}");
/** Messages **/
if (isset($row["currency"])) {
    $c = view("Alerts/warning", array(
        "title" => lang("{$prefix}-create-duplicate-title"),
        "content" => sprintf(lang("{$prefix}-create-duplicate-content"), $d["name"]),
        "buttons" => array(
            array("href" => $link["duplicate"], "text" => lang("App.View")),
            array("href" => $link["continue"], "text" => lang("App.Continue"))
        )
    ));
} else {
    $create = $model->insert($d);
    $c = view("Alerts/success", array(
        "title" => lang("{$prefix}-create-success-title"),
        "content" => sprintf(lang("{$prefix}-create-success-content"), $d["name"]),
        "buttons" => array(
            array("href" => $link["continue"], "text" => lang("App.Continue"))
        )
    ));
}
echo($c);
?>
