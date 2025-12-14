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
$period = $_GET['period'];
//$option = $_GET['option'];
$status = "";
$limit = 200; // Registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
?>
<?php //include("Grid/styles.php"); ?>
    <!-- Card principal -->
    <div id="card-datos" class="card">
        <!-- Header de la card -->
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-table"></i>Profesores Periodo <?php echo($period); ?>
            </h5>
        </div>

        <!-- Cuerpo de la card con tabla scrollable -->
        <div class="card-body p-0" style="height: calc(100vh - 280px);">
            <?php include("Grid/table.php"); ?>
        </div>

        <!-- Footer de la card -->
        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
            <div class="pagination-container py-2">
                <?php //include("Grid/pagination.php"); ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item">
                            <a id="btn-excel" class="page-link" href="#">Excel</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
<?php include("Grid/javascript.php"); ?>