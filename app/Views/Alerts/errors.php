<div class="card text-white bg-danger mb-2 mr-0 ml-0">
    <?php if (!is_null($title)) { ?>
        <div class="card-header">
            <h4 class="m-0 p-0">
                <?php echo(Lang("App.Warning")); ?> - <?php echo($title); ?>
            </h4>
        </div>
    <?php } ?>
    <div class="card-body d-sm-flex align-items-center justify-content-start">
        <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
        <div class="" style="font-size: 1rem; line-height: 1rem;">
            <p class="p-0 m-0"><?php echo($content); ?></p>
            <?php if (isset($errors) && is_array($errors)) { ?>
                <ol class="ml-3 pl-3">
                    <?php foreach ($errors as $error) { ?>
                        <li class="p-0 m-0 "><?php echo($error); ?></li>
                    <?php } ?>
                </ol>
            <?php } else { ?>
                <?php echo($errors); ?>
            <?php } ?>
        </div>
    </div>
    <?php if (isset($buttons)) { ?>
        <div class="card-footer text-right">
            <div class="text-right mt-2 mb-0">
                <?php
                $btns = "";
                if (isset($buttons) && is_array($buttons)) {
                    if (count($buttons) > 0) {
                        foreach ($buttons as $button) {
                            $class = isset($button["class"]) ? "class=\"btn {$button["class"]}\"" : "class=\"btn btn-primary\"";
                            $target = !isset($button["target"]) ? "" : "target=\"{$button["target"]}\" ";
                            $dtoggle = !isset($button["data-toggle"]) ? "" : "data-toggle=\"{$button["data-toggle"]}\" ";
                            $dtarget = !isset($button["data-target"]) ? "" : "data-target=\"{$button["data-target"]}\" ";
                            $btns .= "<a href=\"{$button["href"]}\" {$class} {$target} {$dtoggle} {$dtarget}>{$button["text"]}</a> ";
                        }
                    } else {
                        $btns = null;
                    }
                }
                echo($btns);
                ?>
            </div>
        </div>
    <?php } ?>
</div>
