<!doctype html>
<html lang="es">
<head>
    {include file="_head.tpl"}
</head>
<body data-hash="{csrf_hash()}" data-token="{csrf_token()}">
<div class="body-container">
    {include file="navbar.tpl"}
    {include file="standard/main.tpl"}
    {include file="_footer.tpl"}
    {include file="standard/modals/signin.tpl"}
    {include file="standard/modals/logout.tpl"}
    {if isset($extra)}
        {if $extra=='wrong-access'}
            {include file="standard/modals/wrong-access.tpl"}
        {elseif $extra=='access-granted' }
            {include file="standard/modals/access-granted.tpl"}
        {/if}
    {/if}
</div>
</body>
</html>