<?php
//$articles
$strings = service('strings');

?>
<div class="row" data-masonry='{"percentPosition": true }'>
    <?php foreach ($articles as $article) { ?>
        <?php $title = $strings->get_URLDecode($article['title']); ?>
        <?php $description = $strings->get_URLDecode($article['description']); ?>
        <?php $cover = $article['cover']; ?>
        <?php $date = $article['date'] . " : " . $article['time']; ?>
        <?php $href = "/web/semantic/{$article['semantic']}.html"; ?>
        <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card post">
                <div class="card-header text-center">
                    <?php echo($date); ?>
                </div>
                <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light"
                     data-mdb-ripple-color="light">
                    <img src="<?php echo($cover); ?>" class="img-fluid">
                    <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo($title); ?></h5>
                    <p class="card-text"><?php echo($description); ?></p>
                </div>
                <div class="card-footer  text-center py-0">
                    <a href="<?php echo($href); ?>" class="btn btn-link btn-block stretched-link">
                        Continuar leyendo
                    </a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script async src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
        integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D"
        crossorigin="anonymous"></script>
