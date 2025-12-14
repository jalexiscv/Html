<?php

$countries = model('App\Modules\Disa\Models\Fleet_Countries');
echo(json_encode($countries->get_SelectData()));

?>