<nav id="sidebar" class="sidebar js-sidebar fixed-top">
    <div class="sidebar-content  js-simplebar">
        {include file="assets/brand.tpl"}
        <ul class="sidebar-nav overflow-scroll">
            <li class="sidebar-header">{lang("App.Sections")}</li>
            {if is_array($sidebar)}
                {foreach from=$sidebar key=key item=item}
                    <li class="sidebar-item  {$item.class}">
                        <a class="sidebar-link " href="{$item.href}">
                            {if isset($item.icon)}
                                <i class="align-middle {$item.icon} " data-feather="sliders"></i>
                            {elseif isset($item.svg)}
                                <img class="sidebar-svg" src="/themes/assets/icons/{$item.svg}" width="24px"/>
                            {else}

                            {/if}
                            <span class="align-middle">{$item.text}</span>
                        </a>
                    </li>
                {/foreach}
            {/if}
            {if isset($sidebar_modules) && is_array($sidebar_modules)}
                <li class="sidebar-header">{lang("App.Modules")}</li>
                {foreach from=$sidebar_modules key=key item=item}
                    <li class="sidebar-item  {$item.class}">
                        <a class="sidebar-link " href="{$item.href}">
                            {if isset($item.icon)}
                                <i class="align-middle {$item.icon} " data-feather="sliders"></i>
                            {elseif isset($item.svg)}
                                <img class="sidebar-svg" src="/themes/assets/icons/{$item.svg}" width="24px"/>
                            {else}

                            {/if}
                            <span class="align-middle">{$item.text}</span>
                        </a>
                    </li>
                {/foreach}
            {/if}
        </ul>
    </div>
</nav>