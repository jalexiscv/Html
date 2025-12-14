<?php
$gridter = "";
$gridter .= "<div id=\"gridter\" class='\"inline-block\"'>";
$gridter .= "  <div class=\"d-none d-xxl-block\">XXL</div>";
$gridter .= "  <div class=\"d-none d-xxl-none d-xl-block\">XL</div>";
$gridter .= "  <div class=\"d-none d-xxl-none d-xl-none d-lg-block\">LG</div>";
$gridter .= "  <div class=\"d-none d-xxl-none d-xl-none d-lg-none d-md-block\">MD</div>";
$gridter .= "  <div class=\"d-none d-xxl-none d-xl-none d-lg-none d-md-none d-sm-block\">SM</div>";
$gridter .= "  <div class=\"d-none d-xxl-none d-xl-none d-lg-none d-md-none d-sm-none d-xs-block\">XS</div>";
$gridter .= "</div>";
?>

<div class="benchmark w-100 p--0 m-0">
    <table class="w-100">
        <tbody>
        <tr>
            <td>
                <table class="w-100" style="font-size:15px;text-align:center;line-height:1;margin:0 3px">
                    <tbody>
                    <tr style="color:#737373">
                        <td class="indicator">
                            <?php echo($benchmark); ?>
                        </td>
                        <td class="label">G</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="w-100" style="font-size:15px;text-align:center;line-height:1;margin:0 3px">
                    <tbody>
                    <tr style="color:#737373">
                        <td class="indicator">
                            C8C4
                        </td>
                        <td class="label">T</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td>
                <table class="w-100" style="font-size:15px;text-align:center;line-height:1;margin:0 3px">
                    <tbody>
                    <tr>
                        <td class="indicator">
                            <?php echo($gridter); ?>
                        </td>
                        <td class="label">G</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>