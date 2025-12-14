<div class="container-fluid px-0">
    <div class="container px-0">
        <div class="row ">
            <div class="col-12  col-spa-header-normal">
                <div class="greeting">
                    <div class="custom">{$custom}</div>
                    <div class="proposal">{$proposal}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-4">
                <div class="btns-spa-options mx-0 px-4" style="margin-top: 200px;">
                    <ul class="mx-0 px-2">
                        {foreach from=$main['options'] item=option}
                            <li>
                                <a href="{$option.href}"
                                   class="btn btn-spa-primary btn-lg btn-block w-100 mb-2">{$option.text}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="height:80px;">
            </div>
        </div>
    </div>
</div>