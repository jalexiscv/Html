<div class="card-zensspace pt-4 px-0">
    <div class="card-header zenspace-card-header justify-content-center text-center"><b>{$title}</b></div>
    <div class="card-block special-card pt-3 py-0">
        <center>
            <i class="fas fa-check fa-4x text-warning-d4 float-left mr-4 mt-1 mb-4"></i>
        </center>
        <p class="fs-1  ">{$message}</p>
        {if isset($errors)}
            {$errors}
        {/if}
    </div>
    {if isset($continue)||isset($signin)||isset($help)}
        <div class="card-footer zenspace-card-footer text-center">
            {if isset($cancel)&& !empty($cancel)}
                {if is_array($cancel)}
                    <a href="{$cancel["url"]}" class="btn btn-md btn-secondary">{$cancel["text"]}</a>
                {else}
                    <a href="{$cancel}" class="btn btn-md btn-secondary">{lang("App.Cancel")}</a>
                {/if}
            {/if}
            {if isset($continue)&& !empty($continue)}
                {if is_array($continue)}
                    <a href="{$continue["url"]}" class="btn btn-md btn-secondary">{$continue["text"]}</a>
                {else}
                    <a href="{$continue}" class="btn btn-light mx-auto btn-lg d-block">{lang("App.Continue")}</a>
                {/if}
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
</div>