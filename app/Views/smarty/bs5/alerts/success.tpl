<div class="modal fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog " role="document">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h5 class="modal-title">{$title}</h5>
            </div>
            <div class="modal-body m-3 align-center">
                <div class="row">
                    <div class="col-3 align-items-center">
                        <i class="fas fa-check fa-4x align-center" style="font-size: 5rem;color: #ffffff;"></i>
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
                {if isset($edit)&& !empty($edit)}
                    <a href="{$edit}" class="btn btn-md btn-secondary">{lang("App.Update")}</a>
                {/if}
                {if isset($continue)&& !empty($continue)}
                    <a href="{$continue}" class="btn btn-md btn-primary">{lang("App.Continue")}</a>
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
            var modalsuccess = new bootstrap.Modal(document.getElementById('modal-success'));
            modalsuccess.show();
        }
    </script>
{/literal}