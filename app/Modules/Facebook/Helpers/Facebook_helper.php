<?php

function generate_facebook_permissions()
{
    $model = model("App\Modules\Security\Models\Security_Permissions", true);
    $permissions = array(
        "facebook-access" => "facebook-access-description",
//        "facebook-tickets-access" => "facebook-tickets-access-description",
//        "facebook-tickets-view" => "facebook-tickets-view-description",
//        "facebook-tickets-view-all" => "facebook-tickets-view-all-description",
//        "facebook-tickets-create" => "facebook-tickets-create-description",
//        "facebook-tickets-edit" => "facebook-tickets-edit-description",
//        "facebook-tickets-edit-all" => "facebook-tickets-edit-all-description",
//        "facebook-tickets-delete" => "facebook-tickets-delete-description",
//        "facebook-tickets-delete-all" => "facebook-tickets-delete-all-description",
    );
    foreach ($permissions as $key => $value) {
        $row = $model->where("alias", $key)->first();
        if (!isset($row["alias"])) {
            $d = array(
                "permission" => uniqid(),
                "alias" => strtoupper($key),
                "module" => strtoupper("facebook"),
                "description" => $value,
            );
            $model->insert($d);
        }
    }
}

if (!function_exists("get_events_ticket_form")) {

    function get_events_ticket_form()
    {
        $token_name = csrf_token();
        $token_value = csrf_hash();
        $f = '<form action="/facebook/tickets/view" id="formquey" enctype="multipart/form-data" method="post" accept-charset="utf-8">';
        $f .= "<input name=\"{$token_name}\" type=\"hidden\" value=\"{$token_value}\">";
        $f .= '<div class="form-group row">';
        $f .= '<div class="col-12">';
        $f .= '<div class="input-group">';
        $f .= '<div class="input-group-prepend">';
        $f .= '<div class="input-group-text">';
        $f .= '<i class="fas fa-ticket-alt"></i>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '<input id="ticket" name="ticket" type="text" class="form-control" aria-describedby="tiketHelpBlock" required="required">';
        $f .= '</div>';
        $f .= '<span id="tiketHelpBlock" class="form-text text-muted">Código de 13 caracteres</span>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '<div class="form-group row">';
        $f .= '<div class="col-12">';
        $f .= '<button name="submit" type="submit" class="btn btn-primary">Consultar</button>';
        $f .= '</div>';
        $f .= '</div>';
        $f .= '</form>';
        $c = ""
            . "<div class=\"card mb-1\">"
            . "<div class=\"card-header p-1\"><h5 class=\"card-header-title p-1 opacity-3\">Consultar Boleto</h5></div>"
            . "<div class=\"card-body\">"
            . $f
            . "</div>"
            . "</div>";
        return ($c);
    }

}

function get_facebook_sidebar($active_url = false)
{
    $options = array(
        "home" => array("text" => lang("App.Home"), "href" => "/facebook/", "icon" => "far fa-home"),
        "signin" => array("text" => lang("App.Signin"), "href" => "/facebook/signin/", "icon" => "far fa-ticket-alt", "permission" => "facebook-access"),
        "lotes" => array("text" => lang("App.Lotes"), "href" => "/facebook/lotes/create", "icon" => "far fa-ticket-alt", "permission" => "facebook-tickets-access"),
        "outbox" => array("text" => lang("App.Outbox"), "href" => "/facebook/outbox/", "icon" => "far fa-ticket-alt", "permission" => "facebook-tickets-access"),
    );
    $return = get_application_custom_sidebar($options, $active_url);
    return ($return);
}

?>