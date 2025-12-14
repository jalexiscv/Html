<div class="row row-cols-2 row-cols-md-3 g-4">
    {foreach from=$groups key=key item=item}
        <div class="col d-flex align-items-stretch">
            <div id="group-{$item.group}" data-avatar="/themes/bs5/img/avatars/avatar-neutral.png"
                 data-name="{$item.name}" class="card" style="max-width: 500px;">
                <div class="row g-0">
                    <div class="col-sm-5"
                         style="background-color:#cccccc;background-image: url('{$item.cover}');-webkit-background-size: cover;-moz-background-size:cover;-o-background-size: cover;background-size: cover;">
                        <div style="width: 120px;height: 120px;display: block;" class=""></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-center">
                            <a href="#" onclick="oc('{$item.group}');"
                               class="stretched-link">{urldecode($item.name)}</a>
                            <div><b>Grupo</b>: {$item.group}

                                {if isset($member)}
                                    (Invitado)
                                {/if}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/foreach}
</div>



