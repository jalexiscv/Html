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
                <a href="" data-action="settings"
                   data-bs-toggle="dropdown"
                   aria-expanded="false"
                   class="card-toolbar-btn text-blue-m1">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-caret mr-n3 dropdown-animated">
                    <a class="dropdown-item" href="/social/analysis/{$pid}/{lpk()}">
                        <i class="fal fa-analytics"></i> {lang("App.Analysis")}
                    </a>
                    <a class="dropdown-item" href="/social/posts/send/{$pid}/{lpk()}">
                        <i class="far fa-paper-plane"></i> {lang("App.Send")}
                    </a>
                    <hr class="my-1">
                    <a class="dropdown-item" href="/social/posts/edit/{$pid}/{lpk()}">
                        <i class="far fa-pen-nib"></i> {lang("App.Edit")}
                    </a>
                    <a class="dropdown-item" href="/social/posts/delete/{$pid}/{lpk()}">
                        <i class="far fa-trash-alt"></i> {lang("App.Delete")}
                    </a>

                </div>
            </div>
        </div>


    </div>
    <!--[media]//-->
    {if $cover_visible && !$video}
        <img class="card-img-top" src="{$cover}" alt="">
    {/if}
    {if $video}
        {include file="modules/social/post/player.tpl"}
    {/if}
    <!--[/media]//-->
    <!-- /.card-header -->
    <div class="card-body  p-2">
        <h2 class="title px-2 pb-0 mb-0">{$title}</h2>
        <div class="meta px-2 pb-1">{$by}, {$ago}</div>
        <div class="content px-2">
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










    

    
    
