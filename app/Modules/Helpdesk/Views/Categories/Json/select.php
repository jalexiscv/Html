<?php
$mcategories = model('App\Modules\Helpdesk\Models\Helpdesk_Categories');
$categories = $mcategories->get_SelectData($oid);
$response = array();
if (is_array($categories)) {
    $response['status'] = 200;
    $response['error'] = false;
    $response['categories'] = $categories;
} else {
    $response['status'] = 404;
    $response['error'] = true;
    $response['categories'] = array();
}
echo(json_encode($response));
?>