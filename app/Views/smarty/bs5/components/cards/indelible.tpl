<div class="card">
    <div class="card-header">{$title}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-3">
                <p class="text-center">
                    <i class="fas fa-ban fa-4x text-danger"></i>
                </p>
            </div>
            <div class="col-9">
                <p>{$message}</p>
                {$form}
            </div>
        </div>
        {if isset($voice)}
            <audio src="/themes/assets/audios/{$voice}?lpk={lpk()}" type="audio/mp3" autoplay></audio>
        {/if}
    </div>
</div>
{literal}
    <script async>
        window.onload = function () {
        }
    </script>
{/literal}