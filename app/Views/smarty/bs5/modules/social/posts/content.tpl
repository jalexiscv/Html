<div class="card post mb-2">
    <div class="card-header">
        <h5 class="card-title">
            {$author}
        </h5>
        {if !is_null($channel)}
            <a class="live-link" href="/social/live">EN VIVO <i class="fad fa-heart-rate"></i></a>
        {/if}
        <div class="card-toolbar">
            <div class="dropdown">
                <a href="" data-action="settings" data-toggle="dropdown" class="card-toolbar-btn text-blue-m1">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-caret mr-n3 dropdown-animated">
                    <a class="dropdown-item" href="#" onClick="Redirect('/social/analysis/{$pid}');"><i
                                class="fal fa-analytics"></i> {lang("App.Analysis")}</a>
                    <a class="dropdown-item" href="#" onClick="Redirect('/social/posts/edit/{$pid}');"><i
                                class="far fa-pen-nib"></i> {lang("App.Edit")}</a>
                    <a class="dropdown-item" href="#" onClick="Redirect('/social/posts/delete/{$pid}');"><i
                                class="far fa-trash-alt"></i> {lang("App.Delete")}</a>
                    <!--<li class="divider"></li>//-->
                </div>
            </div>
        </div>
    </div>
    {if $cover_visible && !$video}
        <img class="card-img-top" src="{$cover}" alt="">
    {/if}
    {if $video}
        {include file="modules/social/posts/video.tpl"}
    {/if}
    <!-- /.card-header -->
    <div class="card-body  p-2">
        <h2 class="card-title post-title">{$title}</h2>
        <div class="meta-info pb-1">{$by}, {$ago}</div>
        <div class="content" style="overflow: hidden">
            {if isset($city_name)}
                <span><b>{$city_name}</b>, {$date_textual}</span>
            {/if}
            {$content}
            {if isset($source) && isset($source_alias)}
                {if !empty($source_alias)}
                    <p>
                        <b>Fuente</b>:
                        <a href="{$source}" target="_blank" rel="nofollow">{$source_alias}</a>
                    </p>
                {/if}
            {/if}
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer text-muted"></div>
</div>

<script>
    $(document).ready(function () {
        $.post("/social/posts/ajax/count/{$pid}", {
            '{csrf_token()}': "{csrf_hash()}",
            'post': "{$pid}"
        }, function (data, status) {

        });
    });
</script>









    

    
    
