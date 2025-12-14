<?php if (isset($themostseens) && is_array($themostseens) > 0) { ?>
    <div class="gadget-recent">
        <h4 class="fst-italic">Lo mas visto</h4>
        <ul class="list-unstyled">
            <?php foreach ($themostseens as $themostseen) { ?>
                <?php $title = isset($themostseen['title']) ? $themostseen['title'] : ""; ?>
                <?php $href = "/web/semantic/{$themostseen['semantic']}.html"; ?>
                <?php $cover = "{$themostseen['cover']}"; ?>
                <li>
                    <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                       href="<?php echo($href); ?>">
                        <img class="bd-placeholder-img" width="100%" height="96" src="<?php echo($cover); ?>"></img>
                        <div class="col-lg-8">
                            <h6 class="mb-0"><?php echo(urldecode($title)); ?></h6>
                            <small class="text-body-secondary">January 15, 2023</small>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>

<?php } ?>