<div class="card text-black-50  mb-2 mr-0 ml-0">
    <div class="card-header">
        <h4 class="m-0 p-0 text-md">{$title}</h4>
    </div>
    <div class="card-body d-sm-flex align-items-center justify-content-start">
        {if isset($icon)}
            <i class="{$icon} fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
        {else}
            <i class="fas fa-exclamation-triangle fa-4x text-warning-d4 float-rigt mr-4 mt-1"></i>
        {/if}
        <div class="text-100 line-height-n">
            <p>{$message}</p>
            {if isset($errors)}
                {$errors}
            {/if}
        </div>

    </div>
    <div class="card-footer text-right p-2">
        <form action="" class="" method="POST" accept-charset="utf-8">
            {if isset($submit)}
                <input type="hidden" name="{csrf_token()}" value="{csrf_hash()}" style="display:none;">
                <input type="hidden" name="submited" value="form_confirm" style="display:none;">
                <input type="hidden" name="form_confirm_value" value="{$value}" style="display:none;">
                <button type="submit" class="btn btn-md btn-danger">{$submit}</button>
            {/if}
            {if isset($cancel)}
                <a href="{$cancel}" class="btn btn-md btn-secondary">{lang("App.Cancel")}</a>
            {/if}
            {if isset($voice)}
                <audio src="/themes/assets/sounds/{$voice}" type="audio/mp3" autoplay></audio>
            {/if}
        </form>
    </div>
</div>