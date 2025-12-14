<div class="card text-white bg-danger mb-2 mr-0 ml-0">
    <div class="card-header">
        <h4 class="m-0 p-0">
            {$title}
        </h4>
    </div>
    <div class="card-body d-sm-flex align-items-center justify-content-start">
        <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
        <div class="text-100 line-height-n">
            <p>{$message}</p>
            {if $permissions}
                <p><b>{lang("App.Permissions")}</b>: {$permissions}</p>
            {/if}
        </div>

    </div>
    <div class="card-footer text-right">
        {if $continue}
            <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
        {/if}
        {if isset($help)}
            <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
        {/if}
    </div>
    {if isset($voice)}
        <audio src="/themes/assets/sounds/{$voice}" type="audio/mp3" autoplay></audio>
    {/if}
</div>
