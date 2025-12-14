<!-- mobile //-->
{if isset($main_carousel)}
{if is_array($main_carousel)}
<div id="myCarousel" class="carousel d-block d-sm-block d-md-none mobile" data-bs-ride="carousel">
    <div class="carousel-indicators">
        {foreach from=$main_carousel key=k item=slide}
            {if $k==0}
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{$k}" class="active"
                        aria-label="Slide {$k}" aria-current="true"></button>
            {else}
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{$k}" class=""
                        aria-label="Slide {$k}"></button>
            {/if}
        {/foreach}
    </div>
    <div class="carousel-inner">
        {foreach from=$main_carousel key=k item=slide}
        {if is_array($slide)}
        {if $k==0}
        <div class="carousel-item active">
            {else}
            <div class="carousel-item">
                {/if}
                <img src="{$slide["portrait"]}"/>
                <div class="over"></div>
                <div class="container">
                    <div class="carousel-caption text-start">
                        <h2>{$slide["title"]}</h2>
                        <p>{$slide["description"]}</p>
                        <p><a class="btn btn-lg btn-carousel" href="{$slide["link"]}">Más información</a></p>
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    {/if}
    {/if}

    <!-- desktop //-->

    {if isset($main_carousel)}
    {if is_array($main_carousel)}
    <div id="carouselLandscape" class="carousel slide d-none d-sm-none d-md-block" data-bs-ride="carousel">
        <div class="carousel-indicators">
            {foreach from=$main_carousel key=k item=slide}
                {if is_array($slide)}
                    {if $k==0}
                        <button type="button" data-bs-target="#carouselLandscape" data-bs-slide-to="{$k}" class="active"
                                aria-label="Slide {$k}" aria-current="true"></button>
                    {else}
                        <button type="button" data-bs-target="#carouselLandscape" data-bs-slide-to="{$k}" class=""
                                aria-label="Slide {$k}"></button>
                    {/if}
                {/if}
            {/foreach}
        </div>
        <div class="carousel-inner">
            {foreach from=$main_carousel key=k item=slide}
            {if is_array($slide)}
            {if $k==0}
            <div class="carousel-item active">
                {else}
                <div class="carousel-item">
                    {/if}
                    <img src="{$slide["landscape"]}"/>
                    <div class="over"></div>
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h2>{$slide["title"]}</h2>
                            <p>{$slide["description"]}</p>
                            <p><a class="btn btn-lg btn-carousel" href="{$slide["link"]}">Más información</a></p>
                        </div>
                    </div>
                </div>
                {/if}
                {/foreach}
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselLandscape"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselLandscape"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        {/if}
        {/if}

        {if isset($main_posts)}
            {if is_array($main_posts)}
                <div class="container marketing">
                    {foreach from=$main_posts key=k item=post}
                        <hr class="featurette-divider">
                        <div class="row featurette">
                            <div class="col-md-7">
                                <h2 class="featurette-heading">{$post["title"]}</h2>
                                {$post["content"]}
                            </div>
                            <div class="col-md-5"><img src="{$post["cover"]}"></div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        {/if}