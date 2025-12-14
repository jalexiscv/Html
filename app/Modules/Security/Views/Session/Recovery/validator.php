<?php


$email = $request->getVar("email");
$error = isset($error) ? $error : false;

$mfields = model("App\Modules\Security\Models\Security_Users_Fields");
$user = $mfields->get_UserByEmail($email);
$profile = $mfields->get_Profile($user);
$fullname = $profile['name'];

if (!$user) {
    $error = true;
    $view = view('App\Modules\Security\Views\Session\Recovery\form', array("email" => $email, "error" => $error));
    echo($view);
} else {
    $error = false;
    view('App\Modules\Security\Views\Session\Recovery\Processors\message', array("email" => $email));
    $view = view('App\Modules\Security\Views\Session\Recovery\success', array("email" => $email));
    echo($view);
}
?>