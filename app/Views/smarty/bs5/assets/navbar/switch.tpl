<li class="nav-item">

    {if (get_theme_mode()=="theme-light"||empty(get_theme_mode()))}
        <a class="nav-icon js-switch d-lg-block" href="/api/theme/mode/update/dark">
            <div class="position-relative">
                <i class="far fa-moon-stars"></i>
            </div>
        </a>
    {else}
        <a class="nav-icon js-switch d-lg-block" href="/api/theme/mode/update/light">
            <div class="position-relative">
                <i class="far fa-moon-stars"></i>
            </div>
        </a>
    {/if}
</li>