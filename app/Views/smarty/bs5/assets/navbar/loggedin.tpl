<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-sm-inline-block" href="#" data-bs-toggle="dropdown">
        <img src="{safe_get_user_avatar()}" class="avatar" alt="@{$alias}"/>
    </a>

    <div class="dropdown-menu dropdown-menu-end">
        <a id="link-profile" class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-profile"
           Higgs-user="{$user}"><i class="far fa-user align-middle me-1"></i> {Lang("App.Profile")}</a>
        <a class="dropdown-item" href="#"><i class="far fa-cog align-middle me-1"></i> {Lang("App.Settings")}</a>
        <a class="dropdown-item" href="#"><i class="far fa-analytics align-middle me-1"></i> {Lang("App.Analytics")}</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/security/session/logout/end"><i
                    class="fas fa-power-off align-middle me-1"></i> {Lang("App.Logout")}</a>
    </div>
</li>