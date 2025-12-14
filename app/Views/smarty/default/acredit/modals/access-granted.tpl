<div class="modal fade  " id="loginform-granted" tabindex="-1" role="dialog" aria-labelledby="loginformLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-notify modal-success" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title heading lead" id="loginformLabel">{lang("App.Welcome")}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                    <p>{lang("App.Access-granted")}</p>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/" class="btn btn-success float-right">{lang("App.Continue")}</a>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(window).on('load', function () {
        $('#loginform-granted').modal('show');
    });
</script>