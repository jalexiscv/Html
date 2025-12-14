{if isset($modal)}
    <!-- modal alert //-->
    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Advertencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-100 line-height-n">
                        <p>{$message}</p>
                        {if isset($errors)}
                            {$errors}
                        {/if}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Continuar</button>
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="card text-spa-azul-claro mb-2 mr-0 ml-0">
        <div class="card-header">
            <h4 class="m-0 p-0 text-md">{$title}</h4>
        </div>
        <div class="card-body d-sm-flex align-items-center justify-content-start">
            <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-left mr-4 mt-1"></i>
            <div class="text-100 line-height-n">
                <p>{$message}</p>
                {if isset($errors)}
                    {$errors}
                {/if}
            </div>

        </div>
        {if isset($continue)||isset($signin)||isset($help)}
            <div class="card-footer text-right">
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
                        <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
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
        {if isset($voice)}
            <audio src="/themes/assets/sounds/{$voice}" type="audio/mp3" autoplay></audio>
        {/if}
    </div>
{/if}
