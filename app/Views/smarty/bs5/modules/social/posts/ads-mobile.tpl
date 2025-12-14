<div class="modal fade" id="ads-modal" tabindex="-1" aria-labelledby="ads-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patrocinadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0 m-0" style="min-width: 340px; min-height: 330px;">
                <iframe id="google-ads"
                        title="Publicidad"
                        width="340"
                        height="330"
                        style="border:none"
                        src="/ads/index.php">
                </iframe>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $('#ads-modal').modal("show");
        $('#google-ads').attr('src', function (i, val) {
            return val;
        });

        setTimeout(function () {
            $('#ads-modal').modal('hide');
        }, 30000);

        $(function () {
            var docTimeout = 30000;
            $(document).on("idle.idleTimer", function (event, elem, obj) {
                //console.log("iddle time");
                $('#ads-modal').modal("show");
                $('#google-ads').attr('src', function (i, val) {
                    return val;
                });
            });
            $(document).on("active.idleTimer", function (event, elem, obj, e) {
                console.log("active time");
            });

            $(document).idleTimer({
                timeout: docTimeout,
                timerSyncId: "document-timer-demo"
            });
        });


    });
</script>