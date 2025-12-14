{if $user!="anonymous" && $main_template!="spa-signup"}
    <footer class="d-sm-none footer footer-sm footer-fixed">
        <div class="footer-inner">

            <div class="btn-group d-flex  border-x-1 border-t-2 brc-white bgc-white shadow"
                 style="height: 64px !important;background-color: #ffff;">

                <a href="/spa"
                   class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 command align-self-baseline"
                   style="bottom: 15px;">
                    <img src="/themes/assets/icons/spa/home.svg" width="24" alt=""/>
                </a>

                <a href="/spa/booking?time={time()}"
                   class="btn btn-outline-primary btn-h-lighter-primary btn-a-lighter-primary border-0 command align-self-baseline"
                   style="bottom: 15px;">
                    <img src="/themes/assets/icons/spa/calendar.svg" width="24" alt=""/>
                </a>

                <div class="dropdown dropup spa-btn-footer-center align-self-baseline"
                     style="position: relative;bottom: 20px;">
                    <a href="/spa/catalog/home/{time()}" class="btn bg-transparent" style="top: -40px;">
                        <img src="/themes/assets/icons/spa/center.png" alt="" width="78">
                    </a>
                </div>


                <div class="dropdown-menu " aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>


                <a href="/spa/clients/inbox/{safe_get_user()}?time={time()}"
                   class="btn btn-outline-warning btn-h-lighter-warning btn-a-lighter-warning border-0 command align-self-baseline"
                   style="bottom: 15px;"
                   data-toggle="collapse" data-target="#navbarSearch" aria-controls="navbarSearch"
                   aria-expanded="false" aria-label="Toggle navbar search">
                    <img src="/themes/assets/icons/spa/text.svg" width="24" alt=""/>
                </a>

                <a href="/spa/profiles/view/{safe_get_user()}?time={time()}"
                   class="btn btn-outline-brown btn-h-lighter-brown btn-a-lighter-brown border-0 mr-0 command align-self-baseline"
                   style="bottom: 15px;">
                    <img src="/themes/assets/icons/spa/user.svg" width="24" alt=""/>
                </a>
            </div>
        </div>
    </footer>
{/if}
