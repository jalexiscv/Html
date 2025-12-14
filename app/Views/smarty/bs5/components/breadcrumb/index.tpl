<div class="row">
    <div class="col-12">
        <nav class="navbar navbar-expand-lg  py-1 mb-3 breadcrumb w-100" aria-label="breadcrumb">
            <div class="container-fluid p-0">
                <a class="navbar-brand p-0" href="/"><i class="far fa-home-alt "></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        {if isset($menu)}
                            {foreach from=$menu item=$item}
                                {if !isset($item["levels"])}
                                    <li class="nav-item-divider "></li>
                                    <li class="nav-item">
                                        <a class="nav-link " aria-current="page" href="{$item["href"]}">
                                            {$item["text"]}
                                        </a>
                                    </li>
                                {else}
                                    <li class="nav-item-divider "></li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                           data-bs-toggle="dropdown" aria-expanded="false">{$item["text"]}</a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            {foreach from=$item["levels"] item=$subitem}
                                                {if !isset($subitem["separator"])}
                                                    {if isset($subitem["active"])}
                                                        <li><a class="dropdown-item active"
                                                               href="{$subitem["href"]}">{$subitem["text"]}</a>
                                                        </li>
                                                    {else}
                                                        <li><a class="dropdown-item"
                                                               href="{$subitem["href"]}">{$subitem["text"]}</a></li>
                                                    {/if}
                                                {else}
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                {/if}
                                            {/foreach}
                                            {if isset($item["help"])}
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="$item[" help"]">Ayuda</a></li>
                                            {/if}
                                            {if isset($item["create"])}
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="$item[" create"]">Crear</a></li>
                                            {/if}
                                        </ul>
                                    </li>
                                    <li class="nav-item-divider"></li>
                                {/if}
                            {/foreach}
                        {/if}
                    </ul>
                    <div class="d-flex"></div>
                </div>
            </div>
        </nav>
    </div>
</div>