<!doctype html>
<html lang="es">
<head>
    {include file="_head.tpl"}
</head>
<body data-hash="{csrf_hash()}" data-token="{csrf_token()}">
<div class="body-container">
    {include file="navbar.tpl"}
    {include file="main.tpl"}
    {include file="_footer.tpl"}
    {include file="general/modals/signin.tpl"}
    {include file="general/modals/confirm-logout.tpl"}
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