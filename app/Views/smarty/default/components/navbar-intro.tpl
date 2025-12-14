<div class="navbar-intro justify-content-xl-between">
    <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none"
            data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false"
            aria-label="Toggle sidebar">
        <span class="bars"></span>
    </button><!-- mobile sidebar toggler button -->
    <a class="navbar-brand text-white" href="/?session={session_id()}">
        {if isset($logo) and !empty($logo)}
            <img class="" src="{base_url($logo)}" alt="" height="36"/>
        {else}
            <img class="" src="/themes/assets/logos/default.png" alt="No hay logo definido en la DB" height="36"/>
        {/if}
    </a>
    <button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar" data-target="#sidebar"
            aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
        <span class="bars"></span>
    </button><!-- sidebar toggler button -->
</div><!-- /.navbar-intro -->
