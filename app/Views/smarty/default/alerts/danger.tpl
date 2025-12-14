<div class="card text-white bg-danger mb-2 mr-0 ml-0">
    <div class="card-header">
        <h4 class="m-0 p-0 text-md">{$title}</h4>
    </div>
    <div class="card-body d-sm-flex align-items-center justify-content-start">
        <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
        <div class="text-100 line-height-n">
            <p>{$message}</p>
            {if isset($errors)}
                {$errors}
            {/if}
        </div>

    </div>
    {if isset($continue)||isset($signin)||isset($help)}
        <div class="card-footer text-right">
            {if isset($continue)&& !empty($continue)}
                <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
            {/if}
            {if isset($signin)&& !empty($signin)}
                <a href="#" class="btn btn-md btn-secondary" data-toggle="modal"
                   data-target="#loginform">{lang("App.Signin")}</a>
            {/if}
            {if isset($signup)&& !empty($signup)}
                <a href="{$signup}" class="btn btn-md btn-secondary">{lang("App.Signup")}</a>
            {/if}
            {if isset($help)&& !empty($help)}
                <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
            {/if}
        </div>
    {/if}
    {if isset($voice)}
        <audio src="/themes/assets/sounds/{$voice}" type="audio/mp3" autoplay></audio>
    {/if}
</div>
