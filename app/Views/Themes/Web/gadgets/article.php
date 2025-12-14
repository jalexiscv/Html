<?php $s = service('strings'); ?>
<?php $title = $s->get_URLDecode($article['title']); ?>
<?php $html = $s->get_URLDecode($article['html']); ?>
<?php $cover = $article['cover']; ?>
<?php $date = $article['date'] . " : " . $article['time']; ?>
<article class="blog-post">
    <h2 class="display-5 link-body-emphasis mb-1"><?php echo($title); ?></h2>
    <p class="blog-post-meta"><?php echo($date); ?> <a href="#">Mark</a></p>
    <img class="img-fluid" src="<?php echo($cover); ?>"/>
    <?php echo($html); ?>

</article>