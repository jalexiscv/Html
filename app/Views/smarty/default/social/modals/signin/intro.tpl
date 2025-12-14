<!-- the left side section is carousel in this demo, to show some example variations -->

<div id="loginBgCarousel" class="carousel slide minw-100 h-100">
    <ol class="d-none carousel-indicators">
        <li data-target="#loginBgCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#loginBgCarousel" data-slide-to="1"></li>
        <li data-target="#loginBgCarousel" data-slide-to="2"></li>
        <li data-target="#loginBgCarousel" data-slide-to="3"></li>
    </ol>

    <div class="carousel-inner minw-100 h-100">
        <div class="carousel-item active minw-100 h-100">
            <!-- default carousel section that you see when you open login page -->
            <div style="background-image: url(/themes/assets/image/login-bg-1.svg);"
                 class="px-3 bgc-blue-l4 d-flex flex-column align-items-center justify-content-center minw-100 h-100">
                <a class="my-1" href="/social/">
                    <img src="{get_logo("landscape")}" class="w-100 p-3"/>
                </a>


                <div class="mt-0 mx-4 text-dark-tp3">
                    <div class="paragraph">
                        <p>Únete a nuestra comunidad para estar informado, opinar y hacer amigos, se un cliente
                            preferencial y recibe exclusivos beneficios y descuentos.</p>
                        <p>Completa tus datos. Si ya tienes una cuenta en nuestros portales informativos, inicia sesión
                            con tu correo electrónico y contraseña registrada. </p>
                    </div>
                    <hr class="mb-1 brc-black-tp10"/>
                    <div>
                        <a id="id-start-carousel" href="#" class="text-95 text-dark-l2 d-inline-block mt-3">
                            <i class="far fa-image text-110 text-purple-m1 mr-1 w-2"></i>
                            Noticias & Actualidad
                        </a>
                        <br/>
                        <a id="id-remove-carousel" href="#" class="text-md text-dark-l2 d-inline-block mt-3">
                            <i class="far fa-users text-110 text-orange-d1 mr-1 w-2"></i>
                            Entrevistas & Reportajes
                        </a>
                        <br/>
                        <a id="id-fullscreen" href="#" class="text-md text-dark-l2 d-inline-block mt-3">
                            <i class="fa fa-expand text-110 text-green-m1 mr-1 w-2"></i>
                            Actualidad & Comercio
                        </a>
                    </div>
                </div>

                <div class="mt-auto mb-4 text-dark-tp2">
                    {get_domain()} &copy; 2021
                </div>
            </div>
        </div>


        <div class="carousel-item minw-100 h-100">
            <!-- the second carousel item with dark background -->
            <div style="background-image: url(/themes/assets/image/login-bg-2.svg);"
                 class="d-flex flex-column align-items-center justify-content-start">
                <a class="mt-5 mb-2" href="/social/">
                    <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                </a>

                <h2 class="text-blue-l1">
                    Ace <span class="text-80 text-white-tp3">Application</span>
                </h2>
            </div>
        </div>


        <div class="carousel-item minw-100 h-100">
            <div style="background-image: url(/themes/assets/image/login-bg-3.jpg);"
                 class="d-flex flex-column align-items-center justify-content-start">
                <div class="bgc-black-tp4 radius-1 p-3 w-90 text-center my-3 h-100">
                    <a class="mt-5 mb-2" href="/social/">
                        <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                    </a>

                    <h2 class="text-blue-l1">
                        Ace <span class="text-80 text-white-tp3">Application</span>
                    </h2>
                </div>
            </div>
        </div>


        <div class="carousel-item minw-100 h-100">
            <div style="background-image: url(/themes/assets/image/login-bg-4.jpg);"
                 class="d-flex flex-column align-items-center justify-content-start">
                <a class="mt-5 mb-2" href="/social/">
                    <i class="fa fa-leaf text-success-m2 fa-3x"></i>
                </a>

                <h2 class="text-blue-d1">
                    Ace <span class="text-80 text-dark-tp3">Application</span>
                </h2>
            </div>
        </div>

    </div>
</div>