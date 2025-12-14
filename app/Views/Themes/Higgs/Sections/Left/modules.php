<!--
<div class="dropdown w-100">
    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenu2"
            data-bs-toggle="dropdown"
            aria-expanded="false">
        <?php echo(lang("App.Modules")); ?>
    </button>

    <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenu2">
        <?php $modules = get_application_sidebar(); ?>
        <?php foreach ($modules as $module) { ?>
            <li class="border">
                <a class="dropdown-item" href="<?php echo($module['href']); ?>" target="<?php echo($module['target']); ?>">
                    <?php if (isset($module["icon"])) { ?>
                        <i class="<?php echo($module['icon']); ?> align-middle"></i>
                    <?php } elseif (isset($module["svg"])) { ?>
                        <img src="/themes/assets/icons/<?php echo($module['svg']); ?>" alt=""
                             class="sidebar-svg img-fluid "
                             width="24px">
                    <?php } ?>
                    <?php echo($module['text']); ?>
                </a>
            </li>
        <?php } ?>
    </ul>

</div>
//-->