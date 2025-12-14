<?php
$mfields = model('App\Modules\Sie\Models\Sie_Users_Fields');
$profile = $mfields->get_Profile($oid);

print_r($profile);
?>