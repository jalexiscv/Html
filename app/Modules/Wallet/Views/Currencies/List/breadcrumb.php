<?php
$home = "/wallet?time=" . time();
?>
<div class="page-header">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/disa/"><i class="far fa-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo(lang("Wallet.Wallet")); ?></li>
        </ol>
    </nav>

    <div class="page-tools">
        <a href="<?php echo($home); ?>"
           class="btn btn-sm btn-lighter-default btn-h-lighter-purple btn-a-lighter-purple border-b-2"><i
                    class="fas fa-chevron-left text-120 text-blue-m1"></i></a>
    </div>
</div>