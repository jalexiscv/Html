<?php
$limit = 3000; // Registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

?>
<?php include("styles.php"); ?>
    <div class="container-fluid p-0">
        <div class="table-container">
            <div class="table-scroll">
                <div class="table-wrapper">
                    <?php include("table.php"); ?>
                </div>
            </div>
        </div>
        <div class="pagination-container py-2">
            <?php include("downloader.php"); ?>
        </div>
    </div>
<?php include("javascript.php"); ?>