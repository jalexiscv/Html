<!doctype html>
<html lang="es">
<head>
    {include file="spa/_head.tpl"}
    {include file="spa/styles.tpl"}
</head>
<body data-hash="{csrf_hash()}" data-token="{csrf_token()}" class="spa">
<div class="body-container">
    {include file="spa/navbar.tpl"}
    {include file="spa/main.tpl"}
    {include file="_footer.tpl"}
    {include file="spa/modals/signin.tpl"}
    {include file="spa/modals/confirm-logout.tpl"}
    {if isset($extra)}
        {if $extra=='wrong-access'}
            {include file="spa/modals/wrong-access.tpl"}
        {elseif $extra=='access-granted' }
            {include file="spa/modals/access-granted.tpl"}
        {/if}
    {/if}
</div>
</body>
</html>