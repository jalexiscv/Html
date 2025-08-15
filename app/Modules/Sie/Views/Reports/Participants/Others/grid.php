<?php
//[vars]----------------------------------------------------------------------------------------------------------------
/** @var object $parent */
/** @var string $component */
/** @var string $view */
/** @var object $authentication */
/** @var object $request */
//[Services]-------------------------------------------------------------------------------------------------------------
$request = service('Request');
$bootstrap = service('Bootstrap');
$dates = service('dates');
$strings = service('strings');
$authentication = service('authentication');
//[Models]---------------------------------------------------------------------------------------------------------------
$mregistrations = model('App\Modules\Sie\Models\Sie_Registrations');
$mprograms = model('App\Modules\Sie\Models\Sie_Programs');
$magreements = model('App\Modules\Sie\Models\Sie_Agreements');
$minstitutions = model('App\Modules\Sie\Models\Sie_Institutions');
$mcities = model('App\Modules\Sie\Models\Sie_Cities');
$mdiscounts = model("App\Modules\Sie\Models\Sie_Discounts");
$mdiscounteds = model("App\Modules\Sie\Models\Sie_Discounteds");
$mstatuses = model("App\Modules\Sie\Models\Sie_Statuses");
$mfields = model("App\Modules\Sie\Models\Sie_Users_Fields");
$mexecutions = model("App\Modules\Sie\Models\Sie_Executions");
$mprogress = model("App\Modules\Sie\Models\Sie_Progress");
$morders = model("App\Modules\Sie\Models\Sie_Orders");
//[Data]----------------------------------------------------------------------------------------------------------------
$period = "2025A";
$option = $_GET['option'];
$status = "";
$limit = 200; // Registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
?>
<?php include("Grid/styles.php"); ?>
    <div class="container-fluid">
        <div class="table-container">
            <div class="table-scroll">
                <div class="table-wrapper">
                    <?php include("Grid/table.php"); ?>
                </div>
            </div>
        </div>
        <div class="pagination-container py-2">
            <?php include("Grid/pagination.php"); ?>
        </div>
    </div>
<?php include("Grid/javascript.php"); ?>