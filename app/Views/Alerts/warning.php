<div class="card text-dark bg-warning mb-2 mr-0 ml-0">
    <div class="card-header">
        <h4 class="m-0 p-0">
            <?php echo($title); ?>
        </h4>
    </div>
    <div class="card-body d-sm-flex align-items-center ">
        <i class="far fa-engine-warning fa-4x text-success-d4 float-rigt mr-4 mt-1"></i>
        <p><?php echo($content); ?></p>
    </div>
    <div class="card-footer text-right">
        <?php
        $btns = "";
        if (is_array($buttons)) {
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