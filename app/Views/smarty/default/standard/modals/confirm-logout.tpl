<!-- Central Modal Medium Danger -->
<div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">{Lang("App.Confirm-logout")}</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn"></i>
                    <p>{{Lang("App.Confirm-logout-message")}}</p>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center ">
                <a href="/logout/" class="btn btn-danger text-white"><i
                            class="far fa-sign-out-alt"></i> {Lang("App.Sign-off")}</a>
                <a type="button" class="btn btn-outline-danger waves-effect text-danger"
                   data-dismiss="modal">{Lang("App.Cancel")}</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!-- Central Modal Medium Danger-->