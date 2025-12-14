<header class="border-bottom   py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
            <a class="link-secondary" href="#">Subscribe</a>
        </div>
        <div class="col-4 text-center">
            <a class="blog-header-logo text-body-emphasis text-decoration-none" href="/web/home/index">
                <img id="logo-light" class="logo w-100"
                     src="<?php echo(get_logo("logo_landscape_light")); ?>"/>
                <img id="logo-dark" class="logo w-100"
                     src="<?php echo(get_logo("logo_landscape")); ?>"/>
            </a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            <a class="link-secondary" href="#" aria-label="Search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img"
                     viewBox="0 0 24 24"><title>Search</title>
                    <circle cx="10.5" cy="10.5" r="7.5"/>
                    <path d="M21 21l-5.2-5.2"/>
                </svg>
            </a>
            <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var htmlElement = document.querySelector('html'); // Obtener el elemento <html>
        var theme = htmlElement.getAttribute('data-bs-theme');
        if (theme === 'light') {
            var lgd = document.getElementById('logo-dark'); // Obtener el elemento por su ID
            if (lgd) {
                lgd.classList.add('d-none');
            }
        } else if (theme === 'dark') {
            var lgd = document.getElementById('logo-light'); // Obtener el elemento por su ID
            if (lgd) {
                lgd.classList.add('d-none');
            }
        }
    });
</script>