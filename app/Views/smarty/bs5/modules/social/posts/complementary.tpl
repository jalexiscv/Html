<div class="row">
    <div class="col-xl-6 col-sm-12 pr-xl-1 pr-sm-1">
        {if isset($regionals)}
            {foreach from=$regionals item=post}
                <article class="card card-full hover-a mb-2">
                    <div class="row">
                        <div class="col-4 col-md-4  pr-0 pr-md-0">
                            <div class="image-wrapper">
                                <a href="/social/semantic/{$post["semantic"]}.html">
                                    <img src="{$post["cover"]}" class="img-fluid-news" alt="" width="115" height="80">
                                    <!-- post type -->
                                </a>
                            </div>
                        </div>
                        <div class="col-8 col-md-8">
                            <div class="card-body pt-2 pl-0 pr-2 pb-2">
                                <h3 class="card-title h6 h5-sm h6-lg small-news-text">
                                    <a href="/social/semantic/{$post["semantic"]}.html">
                                        {if isset($post["title"])}
                                            {$post["title"]}
                                        {/if}
                                    </a>
                                </h3>
                                <div class="card-text small text-muted">
                                    <time class="news-date" datetime="">{$post["date"]} {$post["time"]} </time>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            {/foreach}
        {/if}
    </div>
    <div class="col-xl-6 col-sm-12 pl-xl-1 pl-sm-1">
        {if isset($nationals) && is_array($nationals)}
            {foreach from=$nationals item=post}
                <article class="card card-full hover-a mb-2">
                    <div class="row">
                        <div class="col-4 col-md-4  pr-0 pr-md-0">
                            <div class="image-wrapper">
                                <a href="/social/semantic/{$post["semantic"]}.html">
                                    <img src="{$post["cover"]}" class="img-fluid-news" alt="" width="115" height="80">
                                    <!-- post type -->
                                </a>
                            </div>
                        </div>
                        <div class="col-8 col-md-8">
                            <div class="card-body pt-2 pl-0 pr-2 pb-2">
                                <h3 class="card-title h6 h5-sm h6-lg small-news-text">
                                    <a href="/social/semantic/{$post["semantic"]}.html">
                                        {if isset($post["title"])}
                                            {$post["title"]}
                                        {/if}
                                    </a>
                                </h3>
                                <div class="card-text small text-muted">
                                    <time class="news-date" datetime="">{$post["date"]} {$post["time"]}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            {/foreach}
        {/if}
    </div>
</div>  
     
     

        
        

