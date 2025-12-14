<div id="carouselhome" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        {foreach from=$main_carousel key=k item=slide}
        {if is_array($slide)}
        {if $k==0}
        <div class="carousel-item active" data-href="{$slide["link"]}">
            {else}
            <div class="carousel-item" data-href="{$slide["link"]}">
                {/if}
                <img src="https://storage.googleapis.com/cloud-engine{$slide["landscape"]}" class="w-100"
                     style="position: absolute;top: -50%;"/>
                <div class="container visually-hidden">
                    <div class="carousel-caption text-center ">
                        <h2 class="visually-hidden">{$slide["title"]}</h2>
                        <p class="visually-hidden">{$slide["description"]}</p>
                        {if $slide["link"]}
                            <a class="ads-link stretched-link" href="{$slide["link"]}">Más información</a>
                        {/if}
                    </div>
                </div>
            </div>
            {/if}
            {/foreach}
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselhome" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden"><i class="fas fa-angle-left"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselhome" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden"><i class="fas fa-angle-right"></i></span>
        </button>
    </div>
    <script>
        var carousel = document.querySelector('#carouselhome');
        var carouselItems = carousel.querySelectorAll('.carousel-item');
        carouselItems.forEach(function (item) {
            item.addEventListener('click', function () {
                var href = this.getAttribute('data-href');
                window.location.href = href;
            });
        });
    </script>