<div class="card card-success text-white  bg-success mb-3">
    <div class="card-header">
        {if isset($title)}
            <h2 class="">{$title}</h2>
        {/if}
    </div>
    <div class="card-body text-center">
        <div class="text-center">
            <i class="fas fa-check fa-4x mb-3 animated rotateIn color-danger"></i>
            <p>
                {$message}
            </p>
            {if isset($permissions)&&is_array($permissions)}
                <ul class="permissions">
                    {foreach from=$permissions key=k item=v}
                        {if !empty($v)}
                            <li class="permission"><b>{$k}</b>: {$v}</li>
                        {/if}
                    {/foreach}
                </ul>
            {elseif isset($permissions)&&!empty($permissions)}
                <p><b>{lang("App.Permissions")}</b>: {$permissions}</p>
            {/if}

            {if isset($voice)}
                <audio src="/themes/assets/audios/{$voice}?lpk={lpk()}" type="audio/mp3" autoplay></audio>
            {/if}
        </div>
    </div>
    <div class="card-footer text-center bg-success">
        {if $continue}
            <a href="{$continue}" class="btn btn-secondary">{lang("App.Continue")}</a>
        {/if}
        {if isset($help)}
            <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
        {/if}
    </div>
</div>