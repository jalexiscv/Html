<div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-default d-none d-xl-block">
    <div class="sidebar-inner">
        <div class="ace-scroll flex-grow-1" ace-scroll>
            <!-- [sidebar-section-top-buttons] -->
            <ul class="nav has-active-border" role="navigation" aria-label="Main">
                <li class="nav-item-caption">
                    <span class="fadeable pl-3">Secciones</span>
                    <span class="fadeinable mt-n2 text-125">&hellip;</span>
                </li>
                {foreach from=$sidebar key=key item=item}
                    <li class="nav-item {$item.class}">
                        <a href="{$item.href}" class="nav-link">
                            <i class="nav-icon {$item.icon}"></i>
                            <span class="nav-text fadeable">
                                <span>{$item.text}</span>
                            </span>
                        </a>
                        <b class="sub-arrow"></b>
                    </li>
                {/foreach}
                {if isset($sidebar_modules)}
                    <li class="nav-item-caption">
                        <span class="fadeable pl-3">Módulos</span>
                        <span class="fadeinable mt-n2 text-125">&hellip;</span>
                    </li>
                    {if is_array($sidebar_modules) }
                        {foreach from=$sidebar_modules key=key item=item}
                            <li class="nav-item {$item.class}">
                                <a href="{$item.href}" class="nav-link">
                                    <i class="nav-icon {$item.icon}"></i>
                                    <span class="nav-text fadeable">
                                        <span>{$item.text}</span>
                                    </span>
                                </a>
                                <b class="sub-arrow"></b>
                            </li>
                        {/foreach}
                    {/if}
                {/if}
            </ul>
        </div><!-- /.sidebar scroll -->
        <!-- [sidebar-section-admin.tpl] -->
    </div>
</div><!-- /#sidebar -->