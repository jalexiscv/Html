<?php
$server = service("server");
$authentication = service('authentication');
$data = $parent->get_Array();
$origin = $request->getVar("origin");
$referer = $request->getVar("referer");
$data['referer'] = $referer;

if ($origin == "signin") {
    $c = view('App\Modules\Security\Views\Session\Signin\Validators\signin', $data);
} elseif ($origin == "2fa") {
    $c = view('App\Modules\Security\Views\Session\Signin\Validators\2fa', $data);
} else {
    $c = view('App\Modules\Security\Views\Session\Signin\Validators\unknown', $data);
}
echo($c);
?>