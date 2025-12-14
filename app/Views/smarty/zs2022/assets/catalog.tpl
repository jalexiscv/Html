<div class="container-fluid px-0">
    <div class="container px-0 overflow-y">
        <div class="row">
            <div class="col-12">
                <div class="product-cover w-100">
                    <img id="img-cover" src="/themes/zenspace/assets/fotos/1.jpg?v2" class="w-100"/>
                </div>
                <div class="mascara w-100">
                    <div class="greeting">
                        <div class="custom">{$main['custom']}</div>
                        <div class="proposal">{$main['proposal']}</div>
                    </div>
                    <!-- [carrousel] //-->
                    <div id="carousel-catalog" class="carousel carousel-fade" data-bs-ride="carousel"
                    >
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
                                    <div class="carousel-item active text-center"
                                         data-cover="{$producto.cover}"
                                         data-href="{$producto.product}"
                                    >
                                        <div class="subtitle text-center">Estilo de masaje</div>
                                        <div class="title text-center"> {$producto.name}</div>
                                        <div class="description text-center"> {$producto.description}</div>
                                    </div>
                                {else}
                                    <div class="carousel-item text-center"
                                         data-product="{$producto.product}"
                                         data-cover="{$producto.cover}"
                                         data-href="{$producto.product}">
                                        {if $producto.product=="CATALOG"}
                                            <div class="subtitle text-center">Visita nuestro</div>
                                        {else}
                                            <div class="subtitle text-center">Estilo de masaje</div>
                                        {/if}
                                        <div class="title text-center"> {$producto.name}</div>
                                        <div class="description text-center"> {$producto.description}</div>
                                    </div>
                                {/if}
                            {/foreach}
                        </div>
                        <button class="carousel-control-prev carousel-spa-control" type="button"
                                data-bs-target="#carousel-catalog"
                                data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next carousel-spa-control" type="button"
                                data-bs-target="#carousel-catalog"
                                data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="my-3 text-center group-btn-booking">
                        <a id="btn-booking" href="/spa/booking/create/{$main['products'][0].product}"
                           class="btn btn-spa-tornasol btn-lg btn-block " style="z-index: 9999;">
                            Agendar Masaje
                        </a>
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
        var product = item.getAttribute('data-product');
        var cover = item.getAttribute('data-cover');
        var href = item.getAttribute('data-href');
        var image = document.querySelector('#img-cover');
        var btnbooking = document.querySelector('#btn-booking');
        image.setAttribute('src', cover);
        if (product == "CATALOG") {
            btnbooking.textContent = "Ver catálogo";
            btnbooking.setAttribute('href', "/spa/catalog/view/{time()}");
        } else {
            btnbooking.textContent = "Agendar Masaje";
            btnbooking.setAttribute('href', "/spa/booking/create/" + href);
        }
    });
</script>