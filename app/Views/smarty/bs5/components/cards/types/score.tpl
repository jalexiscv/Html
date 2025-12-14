<div class="card flex-row align-items-center align-items-stretch border-0 {if isset($class) AND $class!==false }{$class}{/if}">
    <div class="col-4 d-flex align-items-center bg-gray justify-content-center rounded-left">
        <i class="{if isset($icon) AND $icon!==false }{$icon}{/if} fa-3x"></i>
    </div>
    <div class="col-8 py-3 bg-gray rounded-right">
        <div class="fs-5 lh-5 my-0">
            {if isset($value) AND $value!==false }{$value}{/if}
        </div>
        <div class="    my-0">
            {if isset($description) AND $description!==false }{$description}{/if}
        </div>
    </div>
</div>