<div class="container-fluid px-0">
    <div class="container px-0 overflow-y">
        <div class="row">
            <div class="col-12">
                <div class="product-cover">
                    <img id="img-cover" src="/themes/zenspace/assets/fotos/1.jpg?v2" class="w-100"/>
                </div>
                <div class="mascara w-100">
                    <div class="greeting">
                        <div class="custom">{$main['custom']}</div>
                        <div class="proposal">{$main['proposal']}</div>
                    </div>
                    <!-- [carrousel] //-->
                    <div id="carousel-catalog" class="carousel carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            {$count=0}
                            {foreach from=$main['products'] item=producto}
                                <button type="button" data-bs-target="#carousel-catalog" data-bs-slide-to="{$count}"
                                        class="active" aria-current="true" aria-label="Slide {$count}">
                                </button>
                                {$count=$count+1}
                            {/foreach}
                        </div>
                        <div class="carousel-inner">
                            {$count=0}
                            {foreach from=$main['products'] item=producto}
                                {$count=$count+1}
                                {if $count==1}
                                    <div class="carousel-item active text-center" data-cover="{$producto.cover}">
                                        <div class="subtitle text-center">Estilo de masaje</div>
                                        <div class="title text-center"> {$producto.name}</div>
                                        <div class="description text-center"> {$producto.description}</div>
                                        <div class="my-3">
                                            <a href="/spa/booking/create/{$producto.product}"
                                               class="btn btn-spa-tornasol btn-lg btn-block">Agendar Masaje</a>
                                        </div>
                                    </div>
                                {else}
                                    <div class="carousel-item text-center" data-cover="{$producto.cover}">
                                        <div class="subtitle text-center">Estilo de masaje</div>
                                        <div class="title text-center"> {$producto.name}</div>
                                        <div class="description text-center"> {$producto.description}</div>
                                        <div class="my-3">
                                            <a href="/spa/booking/create/{$producto.product}"
                                               class="btn btn-spa-tornasol btn-lg btn-block">Agendar Masaje</a>
                                        </div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-catalog"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-catalog"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <!-- [/carrousel] //-->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var catalog = document.querySelector('#carousel-catalog');

    catalog.addEventListener('slide.bs.carousel', function (event) {
        var item = event.relatedTarget;
        var cover = item.getAttribute('data-cover');
        var image = document.querySelector('#img-cover');
        image.setAttribute('src', cover);
    });
</script>