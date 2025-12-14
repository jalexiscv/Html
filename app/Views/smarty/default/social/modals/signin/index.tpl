<!--[social-modals-signin-index]-->
<div class="row p-0 m-0" id="row-1">
    <div class="col-12 col-xl-12 bgc-white shadow overflow-hidden">
        <div class="row" id="row-2">
            <div id="id-col-intro" class="col-lg-5 d-none d-lg-flex border-r-1 brc-default-l3 px-0">
                {include file="social/modals/signin/intro.tpl"}
            </div>
            <div id="id-col-main" class="col-12 col-lg-7  bgc-white px-0">
                <!-- you can also use these tab links -->
                <ul class="d-none mt-n4 mb-4 nav nav-tabs nav-tabs-simple justify-content-end bgc-black-tp11"
                    role="tablist">
                    <li class="nav-item mx-2">
                        <a class="nav-link active px-2" data-toggle="tab" href="#id-tab-login" role="tab"
                           aria-controls="id-tab-login" aria-selected="true">
                            Login
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link px-2" data-toggle="tab" href="#id-tab-signup" role="tab"
                           aria-controls="id-tab-signup" aria-selected="false">
                            Signup
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">
                    <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">
                        {include file="social/modals/signin/login.tpl"}
                    </div>
                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-signup" data-swipe-prev="#id-tab-login">
                        {include file="social/modals/signin/signup.tpl"}
                    </div>
                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-forgot" data-swipe-prev="#id-tab-login">
                        {include file="social/modals/signin/forgot.tpl"}
                    </div>
                </div><!-- .tab-content -->
            </div>
        </div><!-- /.row -->
    </div><!-- /.col -->
</div><!-- /.row -->

<div class="d-lg-none my-3 text-white-tp1 text-center">
    <i class="fa fa-leaf text-success-l3 mr-1 text-110"></i> Ace Company &copy; 2021
</div>
<!--[/social-modals-signin-index]-->