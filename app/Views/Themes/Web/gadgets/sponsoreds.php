<style>
    .hover-zoom {
        --mdb-image-hover-zoom-transition: all 0.3s linear;
        --mdb-image-hover-zoom-transform: scale(1.1);
    }

    . sponsored .bg-image {
        position: relative;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 50%;
    }

    .sponsored .bg-image img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

    .sponsored .card-title {
        font-weight: bold;
        line-height: 1rem;
        font-size: 1rem;
    }

</style>

<?php if (isset($sponsoreds) && is_array($sponsoreds) > 0) { ?>
    <?php $title = isset($sponsored['title']) ?? ""; ?>
    <div class="row mb-2">
        <?php foreach ($sponsoreds as $sponsored) { ?>
            <?php $href = "/web/semantic/{$sponsored['semantic']}.html"; ?>
            <?php $cover = "{$sponsored['cover']}"; ?>
            <div class="col-md-6">
                <div class="card sponsored">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo(urldecode($title)); ?></h5>
                                <p class="card-text mb-auto"><?php echo(urldecode($sponsored['description'])); ?></p>
                                <a href="<?php echo($href); ?>" class="icon-link gap-1 icon-link-hover stretched-link">
                                    <?php echo(lang('App.Continue-reading')); ?>
                                    <svg class="bi">
                                        <use xlink:href="#chevron-right"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 bg-image ">
                            <img src="<?php echo($cover); ?>" class="w-100" alt="Imagen">
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>

<?php } ?>