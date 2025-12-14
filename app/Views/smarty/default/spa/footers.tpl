<style>

</style>
<!-- footer toolbox for mobile view -->
<footer class="d-sm-none footer footer-sm footer-fixed">
    <div class="footer-inner">

        <div class="btn-group d-flex h-100 border-x-1 border-t-2 brc-white bgc-white shadow">
            <a href="/spa" class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                <img src="/themes/assets/icons/spa/home.svg" width="24" alt=""/>
            </a>

            <a href="/spa/booking?time={time()}"
               class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0">
                <img src="/themes/assets/icons/spa/calendar.svg" width="24" alt=""/>
            </a>

            <div class="dropdown dropup spa-btn-footer-center">
                <button class="btn dropdown-toggle bg-transparent" style="top: -40px;" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/themes/assets/icons/spa/center.png" alt="" width="78">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item dropdown-item-blue-dark" href="/spa/booking/now?time={pk()}">Solicitar
                        Masaje Ahora</a>
                    <a class="dropdown-item" href="/spa/booking/create/{pk()}">Agendar Masaje</a>
                </div>
            </div>


            <div class="dropdown-menu " aria-labelledby="navbarDropdown1">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>


            <button class="btn btn-outline-warning btn-h-lighter-warning btn-a-lighter-warning border-0"
                    data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch"
                    aria-expanded="false" aria-label="Toggle navbar search">
                <img src="/themes/assets/icons/spa/text.svg" width="24" alt=""/>
            </button>

            <a href="/spa/profiles/view/{safe_get_user()}?time={time()}"
               class="btn btn-outline-brown btn-h-lighter-brown btn-a-lighter-brown border-0 mr-0">
                <img src="/themes/assets/icons/spa/user.svg" width="24" alt=""/>
            </a>
        </div>
    </div>
</footer>