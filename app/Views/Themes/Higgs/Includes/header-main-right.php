<?php
$loggedIn = get_LoggedIn();
$default_class = "btn nav-header-btn rounded-circle p-0 d-flex justify-content-center align-items-center float-right border border-secondary-subtle me-2";
$toggle_class = "btn nav-header-btn rounded-circle p-0 d-flex justify-content-center align-items-center float-right border border-secondary-subtle";

$code = "<ul class=\"navbar-nav ms-auto mb-2 mb-lg-0 d-none d-md-flex\">\n";
//[messages]------------------------------------------------------------------------------------------------------------
$code .= "\t\t<li class=\"nav-item\">\n";
$code .= "\t\t\t\t <button class=\"{$default_class}\">";
$code .= "\t\t\t\t\t<img src=\"/themes/assets/icons/mail.svg?v2\" class=\"header-icon\" alt=\"Messages\" >";
$code .= "\t\t\t\t </button>\n";
$code .= "\t\t</li>\n";

$code .= "\t\t<li class=\"nav-item\" >\n";
$code .= "\t\t\t\t <button id=\"btn-open-modules\" class=\"{$default_class}\">";
$code .= "\t\t\t\t\t<img src=\"/themes/assets/icons/apps.svg\" class=\"header-icon\" alt=\"Apps\" >";
$code .= "\t\t\t\t </button>\n";
$code .= "\t\t</li>\n";

//[color]---------------------------------------------------------------------------------------------------------------
$code .= "\t\t<li class=\"nav-item\">\n";
$code .= "\t\t\t\t<button id=\"header-btn-light\" data-bs-theme-value=\"light\" aria-pressed=\"false\" class=\"{$default_class}\">";
$code .= "\t\t\t\t\t<img src=\"/themes/assets/icons/sun.svg\" class=\"header-icon\" alt=\"Light\" >";
$code .= "\t\t\t\t</button>\n";
$code .= "\t\t\t\t<button id=\"header-btn-dark\" data-bs-theme-value=\"dark\" aria-pressed=\"false\" class=\"{$default_class}\">";
$code .= "\t\t\t\t\t<img src=\"/themes/assets/icons/moon-stars.svg\" class=\"header-icon\" alt=\"Dark\" >";
$code .= "\t\t\t\t</button>\n";
$code .= "\t\t</li>\n";
//[user]----------------------------------------------------------------------------------------------------------------
$code .= "\t\t<li class=\"nav-item\">\n";
if ($loggedIn) {
    $avatar = safe_get_user_avatar();
    $alt = safe_get_alias();
    $code .= "\t\t\t\t\t\t\t\t\t\t<button id=\"btn-open-options\" class=\"{$default_class}\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<img class=\"img-fluid\"  \n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t src=\"{$avatar}\"\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t alt=\"{$alt}\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t</button>\n";
} else {
    $code .= "\t\t\t\t\t\t\t\t\t\t<a class=\"{$default_class}\" href=\"/security/session/signin/index.html\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t<img class=\"navbar-profile-image\"\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t src=\"/themes/bs5/img/avatars/avatar-neutral.png\"\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t\t\t\t\t alt=\"Image\">\n";
    $code .= "\t\t\t\t\t\t\t\t\t\t</a>\n";
}
$code .= "\t\t</li>\n";
//[chat]----------------------------------------------------------------------------------------------------------------
$code .= "\t\t<li class=\"nav-item\">\n";
$code .= "\t\t\t\t<button class=\"{$toggle_class}\" ";
$code .= "\t\t onclick=\"toggleSidebar('rightSidebar')\">";
$code .= "\t\t\t\t\t<img src=\"/themes/assets/icons/mensseger-off.svg\" class=\"header-icon\" alt=\"Mensseger\" >";
$code .= "\t\t\t\t</button>\n";
$code .= "\t\t</li>\n";

$code .= "</ul>\n";
echo($code);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openModalOptions = document.getElementById('btn-open-options');
        const openModalApps = document.getElementById('btn-open-modules');
        const optionsModal = new bootstrap.Modal(document.getElementById('higgs-options-modal'));
        const modulesModal = new bootstrap.Modal(document.getElementById('higgs-options-modules'));
        openModalOptions.addEventListener('click', function () {
            optionsModal.show();
        });
        openModalApps.addEventListener('click', function () {
            modulesModal.show();
        });
    });
</script>