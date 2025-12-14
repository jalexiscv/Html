<div class="card text-center">
    <div class="card-header">
        Restricción
    </div>
    <div class="card-body">
        <div class="text-center">
            <i class="far fa-engine-warning fa-4x mb-3 animated rotateIn color-danger"></i>
            <p>
                El sistema de seguridad le ha denegado acceso a este elemento.
            </p>
        </div>
    </div>
    <div class="card-footer">
        <a href="/" class="btn btn-danger text-white"><i class="far fa-sign-out-alt"></i> Continuar</a>
    </div>
</div>

<div class="modal fade " id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-danger" role="document">
        <div class="modal-content bg-danger">
            <div class="modal-header bg-danger ">
                <h4 class="text-white m-0">Advertencia: Acceso denegado!</h4>
            </div>
            <div class="modal-body align-center">
                <div class="row">
                    <div class="col-auto align-items-center">
                        <i class="fas fa-exclamation-triangle fa-4x align-center" style="font-size: 5rem;"></i>
                    </div>
                    <div class="col-9">
                        <p>{$message}</p>
                        {if is_array($permissions)}
                            <ul class="permissions">
                                {foreach from=$permissions key=k item=v}
                                    {if !empty($v)}
                                        <li class="permission"><b>{$k}</b>: {$v}</li>
                                    {/if}
                                {/foreach}
                            </ul>
                        {elseif !empty($permissions)}
                            <p><b>{lang("App.Permissions")}</b>: {$permissions}</p>
                        {/if}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                {if $continue}
                    <a href="{$continue}" class="btn btn-md btn-secondary">{lang("App.Continue")}</a>
                {/if}
                {if isset($help)}
                    <a href="{$help}" class="btn btn-md btn-secondary">{lang("App.Help")}</a>
                {/if}
            </div>
            {if isset($voice)}
                <audio src="/themes/assets/audios/{$voice}?lpk={lpk()}" type="audio/mp3" autoplay></audio>
            {/if}
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

