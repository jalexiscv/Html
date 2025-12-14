<nav class="navbar px-3 navbar-expand navbar-light ">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            {include file="assets/navbar/switch.tpl"}
            {include file="assets/navbar/fullscreen.tpl"}
            {if $loggedin}
                {include file="assets/navbar/right/messenger-open.tpl"}
                {*include file="assets/navbar/notifications.tpl"*}
                {*include file="assets/navbar/messages.tpl"*}
                {include file="assets/navbar/loggedin.tpl"}
            {else}
                {include file="assets/navbar/signin.tpl"}
            {/if}
        </ul>
    </div>
</nav>