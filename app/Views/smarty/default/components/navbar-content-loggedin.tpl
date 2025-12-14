<div class="navbar-content">

    <button class="navbar-toggler py-2" type="button" data-toggle="collapse" data-target="#navbarSearch"
            aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navbar search">
        <i class="fa fa-search text-white text-90 py-1"></i>
    </button>

    <div class="navbar-content-section collapse navbar-collapse navbar-backdrop" id="navbarSearch">
        <div class="d-flex align-items-center ml-lg-3">
            <i class="fa fa-search text-white mr-n1 d-none d-lg-block"></i>
            <input id="global-search" type="text" class="navbar-search-input px-1 pl-lg-4 ml-lg-n3 w-100 autofocus"
                   placeholder=" {lang("App.Search")} ..." aria-label="{lang("App.Search")}"/>
        </div>
    </div>

</div><!-- .navbar-content -->

<!-- mobile #navbarMenu toggler button -->
<button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu"
        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
            <span class="pos-rel">
                  <img class="border-2 brc-white-tp1 radius-round" width="36" src="{$avatar}" alt="{$alias}">
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-1px mt-1px"></span>
            </span>
</button>