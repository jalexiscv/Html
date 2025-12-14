<div id="modal-danger" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-danger" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{$title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3 align-center">
                <div class="row">
                    <div class="col-3 align-items-center">
                        <i class="fa-duotone fa-triangle-exclamation" style="font-size: 5rem;"></i>
                    </div>
                    <div class="col-9">
                        <p>{$message}</p>
                        {if isset($errors)}
                            {$errors}
                        {/if}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                {if isset($continue)&& !empty($continue)}
                    <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
                {else}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Verificar</button>
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
                {if isset($voice)}
                    <audio src="/themes/assets/audios/{$voice}?lpk={lpk()}" type="audio/mp3" autoplay></audio>
                {/if}
            </div>
        </div>
    </div>
</div>
{literal}
    <script async>
        window.onload = function () {
            var modaldanger = new bootstrap.Modal(document.getElementById('modal-danger'));
            modaldanger.show();
        }
    </script>
{/literal}