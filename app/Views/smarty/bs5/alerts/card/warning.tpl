<div class="card card-warning mb-3">
    <div class="card-header">
        <h2>{$title}</h2>
    </div>
    <div class="card-body text-center">
        <div class="text-center">
            <i class="fa-regular fa-brake-warning fa-4x mb-3 animated rotateIn"></i>
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
    <div class="card-footer text-center">
        {if $continue}
            <a href="{$continue}" class="btn btn-secondary">{lang("App.Continue")}</a>
        {/if}

        {if !get_LoggedIn()}
            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
               data-bs-target="#modalsession">{lang("App.Sign-in")}</a>
        {/if}

        {if isset($help)}
            <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
        {/if}
    </div>
</div>