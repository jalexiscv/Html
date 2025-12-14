<div class="card card-danger mb-3">
    <div class="card-header">
        {$title}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-auto pr-1">
                <i class="icon fa-duotone fa-triangle-exclamation fa-4x mb-3 animated rotateIn"></i>
            </div>
            <div class="col">
                <p>{$message}</p>
                {if isset($permissions)&&is_array($permissions)}
                    <ul class="permissions">
                        {foreach from=$permissions key=k item=v}
                            {if !empty($v)}
                                <li class="permission"><b>{$k}</b>: {$v}</li>
                            {/if}
                        {/foreach}
                    </ul>
                {elseif isset($permissions)&&!empty($permissions)}
                    <br>
                    <b>{lang("App.Permissions")}</b>
                    : {$permissions}
                {/if}
                {if isset($errors)}
                    {$errors}
                {/if}
                {if isset($voice)}
                    <audio src="/themes/assets/audios/{$voice}?lpk={lpk()}" type="audio/mp3" autoplay></audio>
                {/if}
            </div>
        </div>
    </div>
    {if isset($continue) OR isset($help)}
        <div class="card-footer text-center">
            {if $continue}
                <a href="{$continue}" class="btn btn-secondary">{lang("App.Continue")}</a>
            {/if}
            {if isset($help)}
                <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
            {/if}
        </div>
    {/if}
</div>