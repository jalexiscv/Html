<div class="modal fade" id="modal-profile" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{lang("Security.modal-personal-profile")}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modal-profile-body" class="modal-body m-0 bgc-blue-l4">
                {include file="assets/modals/profile/tabs/photo.tpl"}
                <div class="e-profile">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#" class="nav-link active " id="link-security-profile" data-bs-toggle="tab"
                               data-bs-target="#modal-tab-profile">
                                {lang("App.Settings")}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link normal" id="link-security-tab" data-bs-toggle="tab"
                               data-bs-target="#modal-tab-security">
                                {lang("App.Security")}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane active" id="modal-tab-profile" role="tabpanel"
                             aria-labelledby="tab-profile">
                            {include file="assets/modals/profile/tabs/profile.tpl"}
                        </div>
                        <div class="tab-pane fade" id="modal-tab-security" role="tabpanel"
                             aria-labelledby="tab-security">
                            {include file="assets/modals/profile/tabs/security.tpl"}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">{get_domain()} &copy; 2021</div>
        </div>
    </div>
</div>