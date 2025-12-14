<div class="modal fade " id="modal-warning" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog " role="document">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h5 class="modal-title">{$title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3 align-center">
                <div class="row">
                    <div class="col-3 align-items-center">
                        <i class="fas fa-exclamation-triangle fa-4x align-center"
                           style="font-size: 5rem;color: #000;"></i>
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
                    <button id="warning-login" type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {lang("App.Signin")}
                    </button>
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
            var modalwarning = new bootstrap.Modal(document.getElementById('modal-warning'));
            modalwarning.show();

            var warninglogin = document.getElementById('warning-login');
            warninglogin.addEventListener('click', function () {
                var modalsession = new bootstrap.Modal(document.getElementById('modalsession'));
                modalsession.show();
            });
        }
    </script>
{/literal}