<?php
/** @var $oid string */
//[services]------------------------------------------------------------------------------------------------------------
$bootstrap = service("bootstrap");
$musers = model('App\Modules\Security\Models\Security_Users_Fields');
$alias = $musers->get_Field($oid, "alias");
//[vars]----------------------------------------------------------------------------------------------------------------
$back = "/security/users/list/" . lpk();
$table = $bootstrap->get_DynamicTable(array(
        'id' => 'table-' . lpk(),
        'data-url' => '/sie/api/productsbydiscount/json/list/' . $oid,
        'buttons' => array(),
        'cols' => array(
                'check' => array('text' => "", 'class' => 'text-center fit px-2'),
                'product' => array('text' => lang('App.Product'), 'class' => 'text-center'),
                'reference' => array('text' => lang('App.Reference'), 'class' => 'text-center'),
                'name' => array('text' => lang('App.Name'), 'class' => 'text-start'),
                'description' => array('text' => lang('App.Description'), 'class' => 'text-center', 'visible' => false),
                'status' => array('text' => lang('App.Status'), 'class' => 'text-center', 'visible' => false),
                'value' => array('text' => lang('App.Value'), 'class' => 'text-end'),
                'taxes' => array('text' => lang('App.Taxes'), 'class' => 'text-center', 'visible' => false),
                'type' => array('text' => lang('App.Type'), 'class' => 'text-center', 'visible' => false),
                'options' => array('text' => lang('App.Options'), 'class' => 'text-center fit px-2'),
        ),
        'data-page-size' => 100,
        'data-side-pagination' => 'server'
));

$info = $bootstrap->get_Alert(
        array(
                'type' => 'info',
                'title' => lang('App.Remember'),
                "message" => lang("Sie_Discounts.list-info-products-to-which-it-is-applicable")
        )
);
//[build]---------------------------------------------------------------------------------------------------------------
$card = $bootstrap->get_Card("card-view-service", array(
        "title" => lang('Sie_Discounts.list-title-products-to-which-it-is-applicable'),
        "header-back" => $back,
        "content" => $info . $table,
        "voice" => "",
));
echo($card);
?>
<script>
    //Código jquery para detectar cuándo se activa el checkbox
    function check_applied(status, value) {
        console.log("Status: " + status + " Value: " + value);
        var status = status;
        var product = value;
        var user = '<?php echo($oid); ?>';
        var ajaxURL = "/sie/api/productsbydiscount/json/edit/<?php echo($oid); ?>";
        $.ajax({
            method: "POST",
            url: ajaxURL,
            data: {
                "discount": "<?php echo($oid); ?>",
                "product": product,
                "status": status,
                "<?php echo(csrf_token()); ?>": "<?php echo(csrf_hash()); ?>"
            }
        });
    }
</script>
