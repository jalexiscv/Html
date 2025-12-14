<div class="row">
    <div class="col-12 col-sm-auto mb-3">
        <div class="mx-auto" style="width: 140px;">
            <div class="d-flex justify-content-center align-items-end rounded modal-profile-editor-photo"
                 style="
                         background-image: url('{safe_get_user_avatar()}')
                         ">
                <span
                <button class="float-right text-white" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-profile-photo">
                    <i class="fa fa-fw fa-camera"></i>
                </button>
                </span>
            </div>
        </div>
    </div>
    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
        <div class="text-left text-sm-left mb-2 mb-sm-0"><h4
                    class="pt-sm-2 pb-0 mb-0 text-nowrap">{safe_get_user_fullname()}</h4>
            <p class="mb-0">@{safe_get_alias()}</p>
        </div>
    </div>
</div>