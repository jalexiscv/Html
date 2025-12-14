<div class="card card-delete mb-3">
    {include file="assets/card/header.tpl"}
    <div class="card-body">
        <div class="row">
            <div class="col-auto pr-1">
                <i class="icon fa-regular fa-lock  fa-4x mb-3 animated rotateIn"></i>
            </div>
            <div class="col">
                <p>{$message}</p>
                {$form}
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
{literal}
    <script async>
    </script>
{/literal}