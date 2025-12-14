<?php
$referer = !empty($referer) ? $referer : "/";
?>
<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        window.location.href = "<?php echo($referer); ?>";
    });
</script>
