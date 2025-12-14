<?php

$bootstrap = service('Bootstrap');
$f = service("forms", array("lang" => "Standards_Scores."));
//[models]--------------------------------------------------------------------------------------------------------------
$mscores = model("App\Modules\Standards\Models\Standards_Scores");
$mobjects = model('App\Modules\Standards\Models\Standards_Objects');
//[vars]----------------------------------------------------------------------------------------------------------------
$pkey = $f->get_Value("pkey");
$row = $mscores->find($pkey);
/* Vars */
$l["back"] = $f->get_Value("back");
$l["edit"] = "/standards/scores/edit/{$pkey}";
$vsuccess = "standards/scores-delete-success-message.mp3";
$vnoexist = "standards/scores-delete-noexist-message.mp3";
/* Build */
if (isset($row["score"])) {
    $object = $row["object"];
    $delete = $mscores->delete($pkey);
    
    // Clean the cache after deletion to ensure the next query hits the database
    cache()->clean();

    $lastScore = $mscores->getLastScoreForObject($object);
    $newValue = 0;
    if ($lastScore && isset($lastScore["value"])) {
        $newValue = $lastScore["value"];
    }
    $mobjects->update($object, ["value" => $newValue]);

    $c = $bootstrap->get_Card("duplicate", array(
        "class" => "card-success",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Scores.delete-success-title"),
        "text-class" => "text-center",
        "text" => lang("Standards_Scores.delete-success-message"),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vsuccess,
    ));
} else {
    $c = $bootstrap->get_Card("success", array(
        "class" => "card-warning",
        "icon" => "fa-duotone fa-triangle-exclamation",
        "title" => lang("Standards_Scores.delete-noexist-title"),
        "text-class" => "text-center",
        "text" => sprintf(lang("Standards_Scores.delete-noexist-message"), $d['score']),
        "footer-continue" => $l["back"],
        "footer-class" => "text-center",
        "voice" => $vnoexist,
    ));
}
echo($c);
cache()->clean();
?>