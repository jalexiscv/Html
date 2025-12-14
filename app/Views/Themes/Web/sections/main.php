<?php
$data = array(
    "type" => $type,
    "title" => "WIKIVERSO",
    "articles" => $articles,
    "article" => $article,
    "next" => $next,
    "previus" => $previus,
);
?>
<main class="container">
    <?php echo(view($theme . '\gadgets\featured', $data)); ?>
    <?php echo(view($theme . '\gadgets\sponsoreds', $data)); ?>
    <div class="row g-5">
        <div class="col-md-8">
            <h3 class="pb-4 mb-4 fst-italic border-bottom">
                Actualidad Informativa
            </h3>
            <?php if ($type == "home") { ?>
                <?php echo(view($theme . '\gadgets\home', $data)); ?>
            <?php } elseif ($type == "post") { ?>
                <?php echo(view($theme . '\gadgets\article', $data)); ?>
            <?php } elseif ($type == "denied") { ?>
                <?php echo(view($theme . '\gadgets\denied', $data)); ?>
            <?php } else { ?>
                <?php echo(view($theme . '\gadgets\unknown', $data)); ?>
            <?php } ?>
            <nav class="blog-pagination" aria-label="Pagination">
                <a href="<?php echo($next); ?>" class="btn btn-outline-primary rounded-pill">Anteriores</a>
                <a href="<?php echo($previus); ?>" class="btn btn-outline-secondary rounded-pill disabled"
                   aria-disabled="true">Siguientes</a>
            </nav>
            <div class="row">
                <?php

                if (isset($_GET['offset'])) {
                    $offset = $_GET['offset'];
                } else {
                    $offset = 1;
                }

                $previous = $offset - 20;
                $next = $offset + 20;

                $pagination_html = '<ul class="pagination justify-content-center">';

                if ($previous > 0) {
                    $pagination_html .= '<li class="page-item"><a href="?offset=' . $previous . '" class="page-link"><i class="fas fa-chevron-left"></i></a></li>';
                }

                for ($i = 1; $i <= 6; $i++) {
                    $position = $i * 20;
                    $pagination_html .= '<li class="page-item"><a href="?offset=' . $position . '" class="page-link">' . $position / 20 . '</a></li>';
                }

                if ($next <= $offset) {
                    $pagination_html .= '<li class="page-item"><a href="?offset=' . $next . '" class="page-link"><i class="fas fa-chevron-right"></i></a></li>';
                }

                $pagination_html .= '</ul>';

                echo $pagination_html;

                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <?php echo(view($theme . '\gadgets\about', $data)); ?>
                <?php echo(view($theme . '\gadgets\themostseens', $data)); ?>
                <?php echo(view($theme . '\gadgets\archives', $data)); ?>
                <?php echo(view($theme . '\gadgets\elsewhere', $data)); ?>
            </div>
        </div>
    </div>
</main>