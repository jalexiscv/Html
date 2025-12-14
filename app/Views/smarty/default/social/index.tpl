<!doctype html>
<html lang="es">
<head>
    {include file="_head.tpl"}
</head>
<body data-hash="{csrf_hash()}" data-token="{csrf_token()}">
<div class="body-container">
    {include file="navbar.tpl"}
    {include file="social/main.tpl"}
    {include file="_footer.tpl"}
    {include file="social/modals/signin.tpl"}
    {include file="social/modals/logout.tpl"}
    {if isset($extra)}
        {if $extra=='wrong-access'}
            {include file="general/modals/wrong-access.tpl"}
        {elseif $extra=='access-granted' }
            {include file="general/modals/access-granted.tpl"}
        {/if}
    {/if}
</div>
</body>
</html>