<?php

use App\Libraries\Html\HtmlTag;

$b = service('Bootstrap');
$mdatas = model("App\Modules\Nexus\Models\Nexus_Datas");
$oauths = array(
    "facebook",
    "twitter",
    "google",
    "github",
    "linkedin",
);


// Facebook
$vid = $mdatas->get_Field($oid, 'facebook-id');
$vkey = $mdatas->get_Field($oid, 'facebook-key');
$vstatus = $mdatas->get_Field($oid, 'facebook-status');
$sync = $b::get_icon("facebook-updater-icon", array("class" => "fas fa-sync-alt"));
$checkbox = $b::get_checkbox("facebook-checkbox", array("value" => "", "checked" => $vstatus, "label" => "", 'onchange' => "click_checkbox_status(this.checked,'facebook')"));
$id = $b::get_input("facebook-id", array("type" => "text", "placeholder" => "Account ID", "value" => $vid));
$key = $b::get_input("facebook-key", array("type" => "text", "placeholder" => "Secret Key", "value" => $vkey));
$updater = $b::get_button("facebook-updater", array("class" => "btn-primary rounded-circle", "content" => $sync, "onclick" => "click_update_oauth('facebook');"));

$table = HtmlTag::tag('table');
$table->attr('class', "table table-bordered table-hover");

$trh = HtmlTag::tag('tr');
$th1 = $b::get_Th('th1', array('class' => 'text-center', 'content' => "Estado"));
$th2 = $b::get_Th('th2', array('class' => 'text-center', 'content' => "Sistema"));
$th3 = $b::get_Th('th1', array('class' => 'text-center', 'content' => "Id"));
$th4 = $b::get_Th('th1', array('class' => 'text-center', 'content' => "Key"));
$th5 = $b::get_Th('th1', array('class' => 'text-center', 'content' => "Opción"));
$trh->content(array($th1, $th2, $th3, $th4, $th5));

$tr = HtmlTag::tag('tr');
$td1 = $b::get_Td('td1', array('class' => 'text-center', 'content' => $checkbox));
$td2 = $b::get_Td('td2', array('class' => 'text-center', 'content' => "Facebook"));
$td3 = $b::get_Td('td3', array('class' => 'text-center', 'content' => $id));
$td4 = $b::get_Td('td4', array('class' => 'text-center', 'content' => $key));
$td5 = $b::get_Td('td5', array('class' => 'text-center', 'content' => $updater));
$tr->content(array($td1, $td2, $td3, $td4, $td5));

$table->content(array($trh, $tr));
echo($table->render());
?>

<script>

    function click_checkbox_status(status, oauth) {
        //console.log("status:" + status + " / oauth:" + oauth);
        var client = '<?php echo($oid); ?>';
        var url = "/nexus/api/oauths/json/" + oauth + "/check/" + Date.now();
        var formData = new FormData();
        formData.append('client', client);
        formData.append('oauth', oauth);
        formData.append('status', status);
        formData.append('<?php echo(csrf_token());?>', '<?php echo(csrf_hash());?>');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.responseType = 'json';
        xhr.onload = function (e) {
            if (this.status == 200) {
                var response = this.response;
                var message = response.message;
            }
        };
        xhr.setRequestHeader("Cache-Control", "no-cache");
        xhr.send(formData);
    }


    function click_update_oauth(oauth) {
        var client = '<?php echo($oid); ?>';
        var oauth = "facebook";
        var id = document.getElementById('facebook-id');
        var key = document.getElementById('facebook-key');
        var url = "/nexus/api/oauths/json/" + oauth + "/create/" + Date.now();
        document.getElementById('facebook-updater').classList.add("disabled");
        document.getElementById('facebook-updater-icon').classList.add("fa-spin");

        var formData = new FormData();
        formData.append('client', client);
        formData.append('oauth', oauth);
        formData.append('id', id.value);
        formData.append('key', key.value);
        formData.append('<?php echo(csrf_token());?>', '<?php echo(csrf_hash());?>');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.responseType = 'json';
        xhr.onload = function (e) {
            if (this.status == 200) {
                var response = this.response;
                var message = response.message;
                var sigep = message.data;
                document.getElementById('facebook-updater').classList.remove("disabled");
                document.getElementById('facebook-updater-icon').classList.remove("fa-spin");
                //var name = document.getElementById('');
                //name.value = sigep.entidad;
            }
        };
        xhr.setRequestHeader("Cache-Control", "no-cache");
        xhr.send(formData);
    }

</script>