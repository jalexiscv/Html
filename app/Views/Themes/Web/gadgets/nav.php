<?php
$c = "";
$c .= "<nav class=\"navbar nav-underline navbar-expand-md py-0 my-0\">";
$c .= "    <div class=\"container-fluid\">";
if (isset($categories) && is_array($categories)) {
    $c .= "        <button type=\"button\" class=\"navbar-toggler\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarCollapse\">";
    $c .= "            <span class=\"navbar-toggler-icon\"></span>";
    $c .= "        </button>";
    $c .= "        <div class=\"collapse navbar-collapse\" id=\"navbarCollapse\">";
    $c .= "            <div class=\"categories navbar-nav\">";
    foreach ($categories as $category) {
        $text = urldecode($category['title']);
        $href = "/web/categories/{$category['name']}/index.html";
        $status = "";//active
        $c .= "<a class=\"nav-item nav-link py-0 text-nowrap {$status}\" href=\"{$href}\">{$text}</a>";
    }
    $c .= "            </div>";
    $c .= "        </div>";
} else {

}
$c .= "    </div>";
$c .= "</nav>";
echo($c);
?>