{if isset($css)}
<div class="alert alert-success bgc-success-l3 brc-success-m2 d-flex align-items-center {$css}" role="alert">
    {else}
    <div class="alert alert-success bgc-success-l3 brc-success-m2 d-flex align-items-center" role="alert">
        {/if}
        <i class="fas fa-info-circle mr-3 fa-2x text-success"></i>
        <div class="content">
            <b>{$title}</b>: {$message}
        </div>
        {if isset($continue)}
            {if is_array($continue)}
                <a href="{$continue["url"]}" class="btn btn-md {$continue["class"]}">{$continue["text"]}</a>
            {else}
                <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
            {/if}
        {/if}
        {if isset($voice)}
            <audio src="/themes/assets/sounds/{$voice}" autoplay></audio>
        {/if}
    </div>